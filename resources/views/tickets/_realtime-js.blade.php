<script>
document.addEventListener('DOMContentLoaded', function () {
    const ticketId = {{ $ticket->id }};
    const commentForm = document.getElementById('commentForm');
    const messageBox = document.getElementById('commentMessage');
    const commentsDiv = document.getElementById('comments');
    const token = '{{ csrf_token() }}';

    function escapeHtml(text) {
        return text.replace(/[&<>"']/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[s]));
    }

    function appendComment(c, isUser = true) {
    const wrapper = document.createElement('div');
    wrapper.className = isUser ? 'p-3 rounded bg-white border' : 'p-3 rounded bg-gray-100';
    wrapper.innerHTML = `
        <div class="text-xs text-gray-600">
            <strong>${escapeHtml(c.user_name)}</strong> • ${escapeHtml(c.created_at || 'just now')}
        </div>
        <div class="mt-1">${escapeHtml(c.message)}</div>
    `;
    commentsDiv.appendChild(wrapper);
    commentsDiv.scrollTop = commentsDiv.scrollHeight;
}


    commentForm.addEventListener('submit', function(e) {
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
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                messageBox.value = '';
                appendComment(data.comment, true);
            } else {
                alert('Failed to send comment.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error sending comment.');
        });
    });

    // Listen for real-time comments
    if (window.Echo) {
        window.Echo.private('ticket.' + ticketId)
            .listen('CommentAdded', (e) => {
                const c = e.comment;
                const wrapper = document.createElement('div');
                wrapper.className = 'p-3 rounded ' + (c.admin_name ? 'bg-white border' : 'bg-gray-100');
                wrapper.innerHTML = `
                    <div class="text-xs text-gray-600">
                        <strong>${c.user_name || c.admin_name || 'System'}</strong> • ${c.created_at}
                    </div>
                    <div class="mt-1">${c.message}</div>
                `;
                commentsDiv.appendChild(wrapper);
                commentsDiv.scrollTop = commentsDiv.scrollHeight;
            });
    }

});
</script>
