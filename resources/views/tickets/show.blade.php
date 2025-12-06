@extends('layout.layout')
@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
 <div class="flex justify-between items-start">
 <div>
 <h2 class="text-2xl font-semibold">{{ $ticket->title }}</h2>
 <p class="text-sm text-gray-600">Opened by you • {{ $ticket->created_at->toDayDateTimeString() }}</p>
 <p class="text-sm text-gray-600">Category: {{ $ticket->category ?? '—' }}
</p>
 @if($ticket->high_priority) <p class="text-red-600 font-bold">High
Priority</p> @endif
 </div>
 <div class="text-right">
 <span class="inline-block px-3 py-1 border rounded">{{ strtoupper($ticket->status) }}</span>
 </div>
 </div>
 <div class="mt-4 border-t pt-4">
 <p class="whitespace-pre-wrap">{{ $ticket->message }}</p>
 @if($ticket->attachments->count())
 <div class="mt-4">
 <h4 class="font-medium">Attachments</h4>
 <ul>
@foreach($ticket->attachments as $a)
 <li>
 <a href="{{ Storage::url(str_replace('public/','',$a->path)) }}"
target="_blank" class="text-blue-600 underline">{{ $a->filename }}</a> <span
class="text-xs text-gray-500">({{ number_format($a->size/1024,2) }} KB)</span>
 </li>
 @endforeach
 </ul>
 </div>
 @endif
 </div>
 {{-- Comments area --}}
 <div class="mt-6">
 <h3 class="font-semibold">Conversation</h3>
 <div id="comments" class="mt-3 space-y-3 max-h-80 overflow-auto p-3 border
rounded bg-gray-50">
 @foreach($ticket->comments as $c)
 <div class="p-3 rounded {{ $c->user_id == auth()->id() ? 'bg-white
border' : 'bg-gray-100' }}">
 <div class="text-xs text-gray-600">
 <strong>{{ $c->user ? $c->user->name : ($c->admin ? $c->admin->name : 'System') }}</strong> • {{ $c->created_at->diffForHumans() }}
 </div>
 <div class="mt-1">{{ $c->message }}</div>
 </div>
 @endforeach
 </div>
 <form id="commentForm" class="mt-4">
 @csrf
 <textarea id="commentMessage" class="w-full border p-2 rounded" rows="3"
placeholder="Write a message..."></textarea>
 <div class="mt-2 flex items-center gap-2">
 <button id="sendComment" class="bg-blue-600 text-white px-4 py-2
rounded">Send</button>
 <span id="commentStatus" class="text-sm text-gray-600"></span>
 </div>
 </form>
 </div>
</div>
@include('tickets._realtime-js', ['ticket' => $ticket])
@endsection