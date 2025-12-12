@extends('layout.adminlayout')
@section('title')
    <title>Tenant Pro | Admin Tickets</title>
@endsection
@section('content')
<div class="admin-tickets-container">
    <h1 class="page-title">All Tickets</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <table class="tickets-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>User</th>
                <th>Category</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $t)
            <tr>
                <td><a href="{{ route('admin.tickets.show',$t) }}" class="ticket-link">{{ $t->title }}</a></td>
                <td>{{ $t->user->name }}</td>
                <td>{{ $t->category }}</td>
                <td>@if($t->high_priority)<span class="high-priority">High</span>@endif</td>
                <td>{{ ucfirst($t->status) }}</td>
                <td class="actions">
                    <form method="POST" action="{{ route('admin.tickets.claim', $t) }}" class="inline-form">
                        @csrf
                        <button class="btn-action">Claim</button>
                    </form>
                    <a class="btn-action" href="{{ route('admin.tickets.show',$t) }}">Open</a>
                    <form method="POST" action="{{ route('admin.tickets.destroy',$t) }}" onsubmit="return confirm('Delete ticket?');" class="inline-form">
                        @csrf
                        @method('DELETE')
                        <button class="btn-action">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">{{ $tickets->links() }}</div>
</div>
@endsection
