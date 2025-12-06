@extends('layout.adminlayout')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    {{-- Ticket Header --}}
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-2xl font-semibold">{{ $ticket->title }}</h2>
            <p class="text-sm text-gray-600">
                Opened by {{ $ticket->user->name }} • {{ $ticket->created_at->toDayDateTimeString() }}
            </p>
        </div>
        <div class="text-right">
            {{-- Claim Form --}}
            <form id="claimForm" method="POST" action="{{ route('admin.tickets.claim', $ticket) }}">
                @csrf
                <button class="px-3 py-1 bg-blue-600 text-white rounded">Claim</button>
            </form>

            {{-- Status Form --}}
            <form id="statusForm" class="mt-2">
                @csrf
                <select id="status" name="status" class="border p-1 rounded">
                    <option value="open" {{ $ticket->status=='open' ? 'selected' : '' }}>Open</option>
                    <option value="claimed" {{ $ticket->status=='claimed' ? 'selected' : '' }}>Claimed</option>
                    <option value="closed" {{ $ticket->status=='closed' ? 'selected' : '' }}>Closed</option>
                </select>
                <button type="button" id="saveStatus" class="px-2 py-1 border rounded ml-2">Save</button>
            </form>
        </div>
    </div>

    {{-- Ticket Message --}}
    <div class="mt-4 border-t pt-4">
        <p class="whitespace-pre-wrap">{{ $ticket->message }}</p>
    </div>

    {{-- Attachments --}}
    @if($ticket->attachments->count())
    <div class="mt-4">
        <h4 class="font-medium">Attachments</h4>
        <ul>
            @foreach($ticket->attachments as $a)
                <li>
                    <a href="{{ Storage::url(str_replace('public/','',$a->path)) }}" target="_blank" class="text-blue-600 underline">
                        {{ $a->filename }}
                    </a>
                    <span class="text-xs text-gray-500">({{ number_format($a->size / 1024, 2) }} KB)</span>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Comments --}}
    <div class="mt-6">
        <h3 class="font-semibold">Conversation</h3>
        <div id="comments" class="mt-3 space-y-3 max-h-80 overflow-auto p-3 border rounded bg-gray-50">
            @foreach($ticket->comments as $c)
                <div class="p-3 rounded {{ $c->admin_id == auth()->id() ? 'bg-white border' : 'bg-gray-100' }}">
                    <div class="text-xs text-gray-600">
                        <strong>{{ $c->admin ? $c->admin->name : ($c->user ? $c->user->name : 'System') }}</strong>
                        • {{ $c->created_at->diffForHumans() }}
                    </div>
                    <div class="mt-1">{{ $c->message }}</div>
                </div>
            @endforeach
        </div>

        {{-- Admin Comment Form --}}
        <form id="adminCommentForm" class="mt-4">
            @csrf
            <textarea id="adminCommentMessage" class="w-full border p-2 rounded" rows="3" placeholder="Write a message..."></textarea>
            <div class="mt-2 flex items-center gap-2">
                <button id="sendAdminComment" class="bg-blue-600 text-white px-4 py-2 rounded">Send</button>
            </div>
        </form>
    </div>
</div>

@include('tickets._realtime-js', ['ticket' => $ticket])
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Claim ticket
    const claimForm = document.getElementById('claimForm');
    claimForm.addEventListener('submit', function (e) {
        e.preventDefault();
        fetch(claimForm.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(d => { if(d.success) location.reload(); });
    });

    // Update ticket status
    document.getElementById('saveStatus').addEventListener('click', function () {
        const status = document.getElementById('status').value;
        fetch("{{ route('admin.tickets.status', $ticket) }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            body: JSON.stringify({ status })
        })
        .then(r => r.json())
        .then(d => { if(d.success) alert('Status updated'); });
    });

    // Admin comment submit
    const adminCommentForm = document.getElementById('adminCommentForm');
    adminCommentForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = document.getElementById('adminCommentMessage').value.trim();
        if (!message) return;
        fetch("{{ route('admin.tickets.comment', $ticket) }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            body: JSON.stringify({ message })
        })
        .then(r => r.json())
        .then(d => {
            if (d.success) {
                document.getElementById('adminCommentMessage').value = '';
            }
        });
    });
});
</script>
@endpush
