@extends('layout.layout')
@section('title')
    <title>Tenant Pro Settings</title>
@endsection
@section('content')
 <img src="{{ Auth::user()->profile_photo 
            ? asset('profile_photos/' . Auth::user()->profile_photo)
            : asset('default-pfp.png') }}"
     width="120" height="120" style="border-radius: 50%; object-fit: cover;">

<form action="{{ route('settings.update.photo') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>New Profile Photo:</label><br>
    <input type="file" name="profile_photo" accept="image/*" required>

    <br><br>

    <button type="submit">Update Photo</button>
</form>
<a href="/dashboard" class="btn btn-primary">
    ← Back to Dashboard
</a>
@endsection