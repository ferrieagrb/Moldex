@extends('layout.adminlayout')

@section('content')

<header>
        <p id=greetings>Hello Admin {{ auth()->user()->name ?? 'Guest' }}, 👋</p>
    </header>

@endsection