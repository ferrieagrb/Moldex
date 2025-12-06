@extends('layout.adminlayout')

@section('content')

<header>
        <p id=greetings>Hello Admin {{ auth()->user()->name ?? 'Guest' }}, 👋</p>
    </header>

    <style>
      .dashboard-container {
    display: flex;
    flex-wrap: wrap;          
    gap: 25px;                
    padding: 20px 0;
    justify-content: center;   
}

.dashboard-card {
    background: #ffffff;
    padding: 20px 30px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    width: 500px;             
    height: 220px;            
    display: flex;
    align-items: center;      
    justify-content: center;   
    gap: 25px;               
    cursor: pointer;
    transition: transform .15s ease-in-out;
}

.dashboard-card:hover {
    transform: translateY(-5px);
}

.dashboard-card i {
    font-size: 70px;          
    color: #374957;
    flex-shrink: 0;
}

.dashboard-card-title {
    font-size: 20px;
    font-weight: 600;
    color: #374957;
    line-height: 1.3;
}
    </style>

<div class="dashboard-container">
        
     {{--Current Active Residents--}}
     <div class="dashboard-card">
        <img src="/images/icondash1.png" class="dashboard-icon"/>
        <div class="dashboard-card-title">Currently Active Resident</div>
    </div>

    {{--Add Resident--}}
     <div class="dashboard-card" onclick="window.location.href='{{ route('adminresidents') }}'">
        <img src="/images/icondash1.png" class="dashboard-icon"/>
        <div class="dashboard-card-title">Add Resident</div>
    </div>

     {{--Check Units--}}
     <div class="dashboard-card">
        <img src="/images/icondash2.png" class="dashboard-icon"/>
        <div class="dashboard-card-title">Check Units</div>
    </div>
   
    {{--Facility Reservations Tickets--}}
     <div class="dashboard-card">
        <img src="/images/icondash3.png" class="dashboard-icon"/>
        <div class="dashboard-card-title">Facility Reservations Ticket</div>
    </div>
    
    {{--Request--}}
     <div class="dashboard-card">
       <img src="/images/icondash3.png" class="dashboard-icon"/>
        <div class="dashboard-card-title">Request</div>
    </div>


</div>
@endsection