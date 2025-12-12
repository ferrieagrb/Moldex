@extends('layout.layout')

@section('title')
    <title>Forums</title>
@endsection

@section('content')

<h1>Forums</h1>

<button class="button-68" onclick="openCreateModal()" style="margin:15px auto">Add New Post</button>

<!-- Create Modal -->
<div id="createModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
    background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
    <div style="background:white; padding:20px; border-radius:8px; width:300px; text-align:center;">
        <h3>Create New Post</h3>
        <form action="create-post" method="POST">
            @csrf
            <input type="text" name="title" placeholder="Enter title" style="width:100%; margin-bottom:10px;">
            <textarea name="body" placeholder="Enter body" style="width:100%; margin-bottom:10px;"></textarea>
            <button type="submit">Save Post</button>
            <button type="button" onclick="closeCreateModal()" style="margin-top:10px;">Cancel</button>
        </form>
    </div>
</div>

<div class="window-container">
<div class="posts-scroll" style="margin-top: 10px">
    @foreach ($posts as $post)
    <div class="post-item">
        <div class="postrow1">
                <div class="picture">
                    @php
                    $user = $post->user;
                    // If profile_photo exists, use it; else fallback
                    $profilePhoto = $user && $user->profile_photo
                                    ? asset('profile_photos/' . $user->profile_photo)
                                    : asset('images/default-profile.png');
                    @endphp
                    <img src="{{ $profilePhoto }}" alt="{{ $user->name ?? 'User' }}" class="profile-photo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                </div>
                <div class="details">
                    <h3>{{ $post->user->name }}</h3>
                    <p>{{$post['title']}}</p>
                    {{$post['body']}}<br>
                </div>
            </div>
    </div>
    @endforeach
</div>
<h1>My Posts</h1>
<div class="posts-scroll">
    
    @foreach ($ownposts as $mypost)
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

function openCreateModal() {
        document.getElementById('createModal').style.display = 'flex';
    }
function closeCreateModal() {
        document.getElementById('createModal').style.display = 'none';
    }

</script>

@endsection