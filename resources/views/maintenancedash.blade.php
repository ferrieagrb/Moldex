@extends('layout.maintenancelayout')

@section('content')

    <header>
        <p id=greetings>Welcome to the Maintenance tab,{{ auth()->user()->name ?? 'Guest' }} 👋</p>
    </header>

    <style>
/* Main layout wrapper */
.maintenance-dashboard {
    width: 100%;
    max-width: 1800px;
    height: 800px;
    margin: 25px auto 40px auto;

    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 25px;

    /* Ensures full downward stretch */
    min-height: 70vh;
}

/* LEFT large panel */
.large-card {
    background: #ffffff;
    padding: 25px 35px;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    min-height: 600px;
}

/* Ticket Header */
.ticket-header {
    display: flex;
    justify-content: space-between;
    padding: 5px 0 12px 0;
    border-bottom: 1px solid #e5e5e5;
    font-weight: 600;
    color: #2b3a4a;
    font-size: 14px;
}

/* Ticket Rows */
.ticket-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    font-size: 15px;
    color: #2f3b4c;
}

/* Column sizing */
.col-ref {
    width: 60%;
}

.col-status {
    width: 40%;
    text-align: left;
    font-weight: 600;
}

/* Status Colors */
.completed {
    color: #00897B;
}

.progress {
    color: #FB8C00;
}

.pending {
    color: #0277BD;
}

/* RIGHT stacked boxes */
.right-stack {
    display: flex;
    flex-direction: column;
    gap: 25px;
    height: 100%;
}

.dash-card {
    background: #ffffff;
    padding: 25px 30px;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.right-stack .dash-card {
    flex: 1; /* makes both equal and tall */
    min-height: 280px;
}

/* Titles */
.card-title {
    font-size: 22px;
    font-weight: 700;
    color: #2b3a4a;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Optional icons */
.icon-ticket {
    width: 20px;
    height: 20px;
    background-image: url('/icons/ticket.png');
    background-size: cover;
    display: inline-block;
}

/* Boxes inside right cards */
.request-box,
.tool-box {
    background: #00b7a8;
    padding: 15px;
    border-radius: 12px;
    color: white;
    margin-bottom: 15px;
    font-weight: 600;
}

</style>

<div class="maintenance-dashboard">

    <!-- LEFT LARGE CARD -->
    <div class="large-card">
        <h3 class="card-title">
            <i class="icon-ticket"></i> Active Tickets
        </h3>

        <!-- HEADER -->
        <div class="ticket-header">
            <span class="col-ref">Ticket Reference Number</span>
            <span class="col-status">Status</span>
        </div>

        <!-- ROWS -->
        <div class="ticket-row">
            <span class="col-ref">#MT–0012</span>
            <span class="col-status completed">COMPLETED</span>
        </div>
        <div class="ticket-row">
            <span class="col-ref">#MT–1234</span>
            <span class="col-status progress">IN PROGRESS</span>
        </div>
        <div class="ticket-row">
            <span class="col-ref">#MT–4567</span>
            <span class="col-status pending">PENDING</span>
        </div>
    </div>

    <!-- RIGHT SIDE STACK -->
    <div class="right-stack">

        <div class="dash-card">
            <h3 class="card-title">Upcoming Request/s</h3>
            <div class="request-box">#MT-0014</div>
            <div class="request-box">#MT-0013</div>
        </div>

        <div class="dash-card">
            <h3 class="card-title">Recent Tool Assignment</h3>
            <div class="tool-box">
                <p><strong>TOOL:</strong> Power Drill 2</p>
                <p><strong>Type:</strong> Power Tools</p>
                <p><strong>Status:</strong> Active</p>
                <p><strong>User:</strong> Mechanic 4</p>
                <p><strong>Date:</strong> 9/25/2025</p>
            </div>
        </div>

    </div>

</div>


@endsection