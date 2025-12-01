@extends('layout.adminlayout')

@section('content')

<header>
        <p id=greetings>Residents</p>
</header>

\<h1>Invoice #{{ $transaction->id }}</h1>
<p>Tenant: {{ $transaction->bill->user->name }}</p>
<p>Title: {{ $transaction->bill->title }}</p>
<p>Description: {{ $transaction->bill->description }}</p>
<p>Amount Paid: {{ number_format($transaction->amount_paid,2) }}</p>
<p>Method: {{ $transaction->payment_method }}</p>
<p>Date: {{ $transaction->created_at->format('F d, Y H:i') }}</p>
<button onclick="window.print()">Print</button>

@endsection