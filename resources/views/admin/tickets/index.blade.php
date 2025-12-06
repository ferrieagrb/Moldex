@extends('layout.adminlayout')
@section('content')
<div class="p-6">
 <h1 class="text-2xl font-semibold mb-4">All Tickets</h1>
 @if(session('success')) <div class="p-3 bg-green-100 text-green-800 rounded
mb-4">{{ session('success') }}</div> @endif
 <table class="w-full table-auto bg-white rounded shadow">
 <thead>
 <tr class="text-left">
 <th class="px-4 py-2">Title</th>
 <th class="px-4 py-2">User</th>
 <th class="px-4 py-2">Category</th>
 <th class="px-4 py-2">Priority</th>
 <th class="px-4 py-2">Status</th>
<th class="px-4 py-2">Actions</th>
 </tr>
 </thead>
 <tbody>
 @foreach($tickets as $t)
 <tr class="border-t">
 <td class="px-4 py-2"><a href="{{ route('admin.tickets.show',$t) }}"
class="font-semibold">{{ $t->title }}</a></td>
 <td class="px-4 py-2">{{ $t->user->name }}</td>
 <td class="px-4 py-2">{{ $t->category }}</td>
 <td class="px-4 py-2">@if($t->high_priority) <span class="textred-600">High</span> @endif</td>
 <td class="px-4 py-2">{{ ucfirst($t->status) }}</td>
 <td class="px-4 py-2">
 <form method="POST" action="{{ route('admin.tickets.claim', $t) }}"
class="inline-block">@csrf
 <button class="px-2 py-1 border rounded">Claim</button>
 </form>
 <a class="px-2 py-1 border rounded ml-2"
href="{{ route('admin.tickets.show',$t) }}">Open</a>
 <form method="POST" action="{{ route('admin.tickets.destroy',$t) }}"
onsubmit="return confirm('Delete ticket?');" class="inline-block ml-2">@csrf
@method('DELETE')
 <button class="px-2 py-1 border rounded">Delete</button>
 </form>
 </td>
 </tr>
 @endforeach
 </tbody>
 </table>
 <div class="mt-4">{{ $tickets->links() }}</div>
</div>
@endsection
