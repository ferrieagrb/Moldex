@extends('layout.layout')

@section('title')
    <title>Maintenance</title>
@endsection

@section('content')

<header>
    <h1>Maintenance</h1>
</header>

<div class="maintenance-form-box">

    <div class="maintenance-header-inside">
        <img src="/image/icondash2.png" class="maint-icon">
        <div>
            <h2>Need Repairs?</h2>
            <p>Fill out the spaces below to report repairs & regular maintenance on your property</p>
        </div>
    </div>

    <div class="maint-row">
        <input type="text" placeholder="First Name">
        <input type="text" placeholder="Last Name">
        <input type="text" placeholder="Lot/Rm No.">
    </div>

    <div class="maint-row">
        <select>
            <option selected>-----</option>
            <option>Electrical</option>
            <option>Plumbing</option>
            <option>Structural</option>
        </select>

        <textarea placeholder="Report"></textarea>
    </div>

    <button class="maint-submit-btn">Submit</button>
</div>


@endsection