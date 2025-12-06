@extends('layout.layout')

@section('content')

                <!--<h1>Welcome, {{ Auth::user()->name }}!</h1>
                <p>You are now logged in to your account.</p>

                <form action="/logout" method="POST">
                    @csrf
                    <button>Logout</button>
                </form>-->

        @php
use App\Models\Bill;

// Get the latest bill for the logged-in user
$bill = Bill::where('user_id', auth()->id())->latest()->first();
@endphp

        
<div class="db-content">
    <header>
        <p id=greetings>Hello {{ auth()->user()->name ?? 'Guest' }}, 👋</p>
    </header>
    <div class="columns">
        <div class="column1">
            <div class="row1">
                <div class="bills" onclick="window.location.href='{{ route('finance') }}'" style="cursor:pointer;">
                    <div class="image">
                    <img src="../images/3dicons-wallet.png" height="130px" width="130px">
                    </div>
                    <div class="due-review">    
                        @if($bill)
                            @php
                                $displayAmount = ($bill->status === 'paid') ? 0 : $bill->amount;
                            @endphp
                            <div class="fn-tile">
                                <p id=amount><strong>$<span id="bill-amount-{{ $bill->id }}">{{ $displayAmount }}</span></strong></p>
                                <p><strong>Due:</strong> {{ \Carbon\Carbon::parse($bill->due_date)->format('F d, Y') }}</p>
                                <p><strong>Status:</strong> {{ $bill->status }}</p>
                            </div>
                        @else
                            <p>Amount: 0 pesos</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row2" >
                <div class="tile" onclick="window.location.href='{{ route('tickets.index') }}'" style="cursor:pointer;">
                    <img src="../images/3dicons-document.png" height="100px" width="100px">
                    <p> Tickets </p>
                </div>
                <div class="tile" id=rw-tile2 onclick="window.location.href='{{ route('maintenance') }}'" style="cursor:pointer;">
                    <img src="../images/3dicons-document.png" height="100px" width="100px">
                    <p> Borrowing </p>
                </div>
            </div>
            <div class="row3">
                <div class="tile" onclick="window.location.href='{{ route('tickets.create') }}'" style="cursor:pointer;">
                    <img src="../images/3dicons-phone.png" height="100px" width="100px">
                    <p> Submit an Admin Ticket </p>
                </div>
                <div class="tile"id=rw-tile2 onclick="window.location.href='{{ route('documents') }}'" style="cursor:pointer;">
                    <img src="../images/3dicons-tools.png" height="100px" width="100px">
                    <p> Submit Repair Ticket </p>
                </div>
            </div>
        </div>
        <div class="column2">
            <div class="posts-scroll2">
                @foreach ($posts as $post)
                <div class="post-item">
                    <div class="postrow1-2">
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
        </div>
    </div>
</div>

@endsection