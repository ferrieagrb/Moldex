@extends('layout.layout')

@section('content')

                <!--<h1>Welcome, {{ Auth::user()->name }}!</h1>
                <p>You are now logged in to your account.</p>

                <form action="/logout" method="POST">
                    @csrf
                    <button>Logout</button>
                </form>-->
            
<div class="db-content">
    <header>
        <p id=greetings>Hello {{ auth()->user()->name ?? 'Guest' }}, 👋</p>
    </header>
    <div class="columns">
        <div class="column1">
            <div class="row1">
                <div class="bills">
                    <h1>hello</h1>
                </div>
            </div>
            <div class="row2"> <div class="div"></div>
                <div class="tile">
                    <h2>wo</h2>
                </div>
                <div class="tile">
                    
                </div>
            </div>
            <div class="row3">
                <div class="tile">

                </div>
                <div class="tile">
                    
                </div>
            </div>
        </div>
        <div class="column2">
            <div class="announce">

            </div>
        </div>
    </div>
</div>

@endsection