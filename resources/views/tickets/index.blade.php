@extends('layout.layout')
@section('title')
    <title>Tenant Pro | My Tickets</title>
@endsection
@section('content')
<div class="tickets-container">
    <div class="tickets-header">
        <h2>My Tickets</h2>
        <a href="{{ route('tickets.create') }}" class="btn-new-ticket">New Ticket</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="tickets-grid">
        @forelse ($tickets as $t)
        <div class="ticket-card">
            <div class="ticket-card-header">
                <div>
                    <h3>{{ $t->title }}</h3>
                    <p class="category">Category: {{ $t->category ?? '—' }}</p>
                    <p class="opened">Opened: {{ $t->created_at->diffForHumans() }}</p>
                </div>
                <div class="ticket-status">
                    @if($t->high_priority)
                        <span class="high-priority">HIGH</span><br/>
                    @endif
                    <span class="status">{{ strtoupper($t->status) }}</span>
                </div>
            </div>
            <p class="ticket-message">{{ Str::limit($t->message, 180) }}</p>
            <div class="ticket-actions">
                <a href="{{ route('tickets.show',$t) }}" class="btn-overview">Open / Overview</a>
            </div>
        </div>
        @empty
        <p class="no-tickets">You don't have any tickets yet.</p>
        @endforelse
    </div>

    <div class="pagination">{{ $tickets->links() }}</div>
</div>
@endsection