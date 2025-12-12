@extends('layout.adminlayout')
@section('title')
    <title>Tenant Pro | Admin Units</title>
@endsection
@section('content')

<header>
    <p id="greetings">Upload User Documents</p>
</header>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form action="{{ url('/adminunits') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Select User -->
    <label for="user_id">User:</label>
    <select name="user_id" id="user_id" required>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <!-- Document Type -->
    <label for="type">Document Type:</label>
    <select name="type" id="type" required>
        <option value="property_lease">Property / Lease</option>
        <option value="certificate">Certificate of Occupancy</option>
        <option value="deed">Deed of Sale</option>
        <option value="ticket">Ticket History</option>
    </select>

    <!-- File Input -->
    <label for="file">Choose File (PDF only):</label>
    <input type="file" name="file" id="file" accept="application/pdf" required>

    <!-- Submit Button -->
    <button type="submit" class="docu-button">Upload</button>
</form>

@endsection
