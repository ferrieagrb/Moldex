@extends('layout.layout')
@section('content')
<div class="max-w-5xl mx-auto p-6">
 <div class="flex justify-between items-center mb-6">
 <h2 class="text-2xl font-semibold">My Tickets</h2>
 <a href="{{ route('tickets.create') }}" class="bg-green-600 text-white px-4
py-2 rounded">New Ticket</a>
 </div>
 @if(session('success')) <div class="p-3 bg-green-100 text-green-800 rounded
mb-4">{{ session('success') }}</div> @endif
 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
 @forelse ($tickets as $t)
 <div class="border rounded p-4 shadow-sm">
 <div class="flex justify-between items-start">
 <div>
 <h3 class="font-semibold text-lg">{{ $t->title }}</h3>
 <p class="text-sm text-gray-600">Category: {{ $t->category ?? '—' }}
</p>
 <p class="text-xs text-gray-500">Opened: {{ $t->created_at->diffForHumans() }}</p>
 </div>
 <div class="text-right">
 @if($t->high_priority)
 <span class="text-red-600 font-bold">HIGH</span><br/>
 @endif
 <span class="px-2 py-1 rounded text-sm border">{{ strtoupper($t->status) }}</span>
 </div>
</div>
<p class="mt-3 text-gray-700 truncate">{{ Str::limit($t->message,
180) }}</p>
 <div class="mt-4 flex gap-2">
 <a href="{{ route('tickets.show',$t) }}" class="text-sm px-3 py-1
border rounded">Open / Overview</a>
 </div>
 </div>
 @empty
 <p class="text-gray-600">You don't have any tickets yet.</p>
 @endforelse
 </div>
 <div class="mt-6">{{ $tickets->links() }}</div>
</div>
@endsection