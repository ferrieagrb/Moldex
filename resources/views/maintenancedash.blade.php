@extends('layout.maintenancelayout')

@section('content')

    <header>
        <p id=greetings>Hello Maintenance {{ auth()->user()->name ?? 'Guest' }}, 👋</p>
    </header>


@endsection