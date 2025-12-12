@extends('layout.adminlayout')
@section('title')
    <title>Tenant Pro | Ticket {{ $ticket->title }}</title>
@endsection
@section('content')
<div class="ticket-container">
    <div class="ticket-header">
        <div>
            <h2 class="ticket-title">{{ $ticket->title }}</h2>
            <p class="ticket-meta">Opened by {{ $ticket->user->name }} • {{ $ticket->created_at->toDayDateTimeString() }}</p>
        </div>
        <div class="ticket-actions">
            <form id="claimForm" method="POST" action="{{ route('admin.tickets.claim', $ticket) }}">
                @csrf
                <button>Claim</button>
            </form>
            <form id="statusForm">
                @csrf
                <select id="status" name="status">
                    <option value="open" {{ $ticket->status=='open' ? 'selected' : '' }}>Open</option>
                    <option value="claimed" {{ $ticket->status=='claimed' ? 'selected' : '' }}>Claimed</option>
                    <option value="closed" {{ $ticket->status=='closed' ? 'selected' : '' }}>Closed</option>
                </select>
                <button type="button" id="saveStatus">Save</button>
            </form>
        </div>
    </div>

    <div class="ticket-message">{{ $ticket->message }}</div>

    @if($ticket->attachments->count())
    <div class="ticket-attachments">
        <h4>Attachments</h4>
        <ul>
            @foreach($ticket->attachments as $a)
            <li>
                <a href="{{ Storage::url(str_replace('public/','',$a->path)) }}" target="_blank">{{ $a->filename }}</a>
                <span>({{ number_format($a->size / 1024, 2) }} KB)</span>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="comments">
        <h3 class="comments-header">Conversation</h3>
        <div id="comments" class="comments-list">
            @foreach($ticket->comments as $c)
            <div class="comment {{ $c->admin_id ? 'admin' : '' }}">
                <div class="comment-meta">
                    <strong>{{ $c->admin ? $c->admin->name : ($c->user ? $c->user->name : 'System') }}</strong> • {{ $c->created_at->diffForHumans() }}
                </div>
                <div>{{ $c->message }}</div>
            </div>
            @endforeach
        </div>

        <form id="adminCommentForm" class="admin-comment-form">
            @csrf
            <textarea id="adminCommentMessage" rows="3" placeholder="Write a message..."></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
</div>

@include('tickets._realtime-js', ['ticket' => $ticket])


<script>
document.addEventListener('DOMContentLoaded', function () {
    const adminCommentForm = document.getElementById('adminCommentForm');
    const messageInput = document.getElementById('adminCommentMessage');
    const commentsDiv = document.getElementById('comments');

    if (!adminCommentForm || !messageInput) return;

    // Enter sends, Shift+Enter newline
    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            adminCommentForm.dispatchEvent(new Event('submit', { cancelable: true }));
        }
    });

    function addCommentToDiv(comment) {
        const newComment = document.createElement('div');
        newComment.className = 'p-3 rounded bg-white border transition-opacity duration-200 opacity-0';
        newComment.innerHTML = `
            <div class="text-xs text-gray-600">
                <strong>${comment.admin_name || comment.user_name || 'System'}</strong> • ${comment.created_at}
            </div>
            <div class="mt-1">${comment.message}</div>
        `;
        commentsDiv.appendChild(newComment);
        // fade in
        requestAnimationFrame(() => {
            newComment.classList.remove('opacity-0');
        });
        commentsDiv.scrollTop = commentsDiv.scrollHeight;
    }

    // Submit handler
    adminCommentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;

        const formData = new FormData();
        formData.append('message', message);

        fetch("{{ route('admin.tickets.comment', $ticket) }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                addCommentToDiv(data.comment);
            } else {
                alert('Failed to save comment.');
            }
        })
        .catch(err => console.error(err));
    });
});
</script>

@endsection




