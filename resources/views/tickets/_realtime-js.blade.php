<script>
document.addEventListener('DOMContentLoaded', function () {
 const ticketId = {{ $ticket->id }};
 const commentForm = document.getElementById('commentForm');
 const messageBox = document.getElementById('commentMessage');
 const commentsDiv = document.getElementById('comments');
 const token = '{{ csrf_token() }}';
 commentForm.addEventListener('submit', function (e) {
 e.preventDefault();
 const message = messageBox.value.trim();
 if (!message) return;
 fetch("{{ route('tickets.comment', $ticket) }}", {
 method: 'POST',
 headers: {
 'X-CSRF-TOKEN': token,
 'Accept': 'application/json',
 'Content-Type': 'application/json'
 },
 body: JSON.stringify({ message })
 }).then(r => r.json())
 .then(data => {
 if (data.success) {
 messageBox.value = '';
 appendComment(data.comment);
 } else {
 alert('Failed to send comment.');
 }
 }).catch(err => {
 console.error(err);
 alert('Error sending comment.');
 });
 });
 function appendComment(c) {
 const wrapper = document.createElement('div');
 wrapper.className = 'p-3 rounded bg-white border';
 wrapper.innerHTML = `<div class="text-xs text-gray-600"><strong>${c.user ?
c.user.name : 'You'}</strong> • just now</div><div class="mt-1">$
{escapeHtml(c.message)}</div>`;
 commentsDiv.appendChild(wrapper);
 commentsDiv.scrollTop = commentsDiv.scrollHeight;
 }
function escapeHtml(text) {
 return text.replace(/[&<>\"]/g, s =>
({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[s]));
 }
 if (window.Echo) {
 window.Echo.private('ticket.' + ticketId)
 .listen('CommentAdded', (e) => {
 const c = e.comment;
 // Prevent duplicates: you may refine this by checking ids
 const wrapper = document.createElement('div');
 wrapper.className = 'p-3 rounded bg-gray-100';
 wrapper.innerHTML = `<div class="text-xs text-gray-600"><strong>$
{c.user ? c.user.name : (c.admin ? c.admin.name : 'System')}</strong> • ${new
Date(c.created_at).toLocaleString()}</div><div class="mt-1">$
{escapeHtml(c.message)}</div>`;
 commentsDiv.appendChild(wrapper);
 commentsDiv.scrollTop = commentsDiv.scrollHeight;
 });
 }
});
</script>