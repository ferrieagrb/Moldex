@extends('layout.adminlayout')

@section('content')
<div class="container" style="max-width:800px; margin:20px auto;">
    <h2>Issue Invoice</h2>

    @if(session('success'))
        <div style="padding:10px; background:#d4edda; border:1px solid #c3e6cb; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="padding:10px; background:#f8d7da; border:1px solid #f5c6cb; margin-bottom:15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.invoice.store') }}">
        @csrf

        <div style="margin-bottom:10px;">
            <label>User</label>
            <select name="user_id" required style="width:100%; padding:8px;">
                <option value="">Select user</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:10px;">
            <label>Amount</label>
            <input type="number" name="amount" step="0.01" required style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label>Description</label>
            <textarea name="description" rows="3" style="width:100%; padding:8px;"></textarea>
        </div>

        <div style="margin-bottom:10px;">
            <label>Due Date</label>
            <input type="date" name="due_date" style="width:100%; padding:8px;">
        </div>

        <button type="submit" style="padding:10px 16px; background:black; color:white; border:none;">Issue Invoice</button>
    </form>
</div>
@endsection
