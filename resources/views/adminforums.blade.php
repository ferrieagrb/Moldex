@extends('layout.adminlayout')
@section('title')
    <title>Tenant Pro | Admin Forums</title>
@endsection
@section('content')

<header>
        <p id=greetings>Forum Management</p>
</header>

<div class="posts-scroll" style="margin-top: 10px">
    @foreach ($posts as $mypost)
        <div class="post-item">
            <div class="postrow1">
                <div class="picture">
                    @php
                    $user = $mypost->user;
                    // If profile_photo exists, use it; else fallback
                    $profilePhoto = $user && $user->profile_photo
                                    ? asset('profile_photos/' . $user->profile_photo)
                                    : asset('images/default-profile.png');
                    @endphp
                    <img src="{{ $profilePhoto }}" alt="{{ $user->name ?? 'User' }}" class="profile-photo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                </div>
                <div class="details">
                    <h3>{{ $mypost->user->name }}</h3>
                    <p>{{$mypost['title']}}</p>
                    {{$mypost['body']}}<br>
                </div>
            </div>
            <div class="buttons">
                <p>
                    <button class="button-68" onclick="openEditModal({{ $mypost->id }}, '{{ $mypost->title }}', '{{ $mypost->body }}')">Edit</button>
                </p>
                <form action="/delete-post/{{$mypost->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="button-68">DELETE</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<!-- Edit Modal -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
    background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
    <div style="background:white; padding:20px; border-radius:8px; width:300px; text-align:center;">
        <h3>Edit Post</h3>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="text" id="editTitle" name="title" placeholder="Enter title" style="width:100%; margin-bottom:10px;">
            <textarea id="editBody" name="body" placeholder="Enter body" style="width:100%; margin-bottom:10px;"></textarea>

            <button type="submit">Save Changes</button>
            <button type="button" onclick="closeEditModal()" style="margin-top:10px;">Cancel</button>
        </form>
    </div>
</div>

<script>
    let currentpostId = null;

function openEditModal(postId, title, body) {
    currentPostId = postId;

    document.getElementById('editTitle').value = title;
    document.getElementById('editBody').value = body;

    document.getElementById('editForm').action = `/update-post/${postId}`;
    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}
</script>
@endsection