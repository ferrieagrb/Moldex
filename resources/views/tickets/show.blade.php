@extends('layout.layout')
@section('title')
    <title>Tenant Pro | Ticket {{ $ticket->title }}</title>
@endsection
@section('content')
<form action="{{ route('tickets.index') }}" method="GET">
    @csrf
    <button class="button-68" type="submit">Back</button>
</form>

<div class="ticket-container">
    {{-- Ticket Header --}}
    
    <div class="ticket-header">
        
        <div>
            <h2 class="ticket-title">{{ $ticket->title }}</h2>
            <p class="ticket-meta">Opened by you • {{ $ticket->created_at->toDayDateTimeString() }}</p>
            <p class="ticket-meta">Category: {{ $ticket->category ?? '—' }}</p>
            @if($ticket->high_priority)
                <p class="ticket-high-priority">High Priority</p>
            @endif
        </div>
        <div class="ticket-status">
            <span>{{ strtoupper($ticket->status) }}</span>
        </div>
    </div>

    {{-- Ticket Message --}}
    <div class="ticket-message">
        <p>{{ $ticket->message }}</p>
    </div>

    {{-- Attachments --}}
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

    {{-- Comments --}}
    <div class="comments">
        <h3>Conversation</h3>
        <div id="comments" class="comments-list">
            @foreach($ticket->comments as $c)
            <div class="comment {{ $c->user_id == auth()->id() ? 'user' : 'other' }}">
                <div class="comment-meta">
                    <strong>{{ $c->user ? $c->user->name : ($c->admin ? $c->admin->name : 'System') }}</strong> • {{ $c->created_at->diffForHumans() }}
                </div>
                <div>{{ $c->message }}</div>
            </div>
            @endforeach
        </div>

        {{-- User Comment Form --}}
        <form id="commentForm" class="comment-form">
            @csrf
            <textarea id="commentMessage" rows="3" placeholder="Write a message..."></textarea>
            <div class="comment-form-footer">
                <button id="sendComment" type="submit">Send</button>
                <span id="commentStatus"></span>
            </div>
        </form>
    </div>
</div>

@include('tickets._realtime-js', ['ticket' => $ticket])

@endsection