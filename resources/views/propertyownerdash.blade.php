@extends('layout.ownerlayout')

@section('content')

<header>
        <p id=greetings>Hello Admin {{ auth()->user()->name ?? 'Guest' }}, 👋</p>
    </header>

    <style>
   .tenantpro-dashboard {
    width: 100%;
}

.dash-title {
    font-size: 22px;
    margin-bottom: 20px;
    font-weight: 600;
    color: #000;
}

.dash-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
}

.dash-box {
    background: #fff;
    border-radius: 20px;
    padding: 25px;
    box-shadow: rgba(0, 0, 0, 0.07) 0px 4px 12px;
    display: flex;
    flex-direction: column;
    /* Remove vertical centering */
    justify-content: flex-start;  /* Align items to top */
}

.box-large {
    height: 400px;
}

.box-medium {
    height: 420px;
}

.box-title {
    font-size: 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 15px;
}

.box-title i {
    font-size: 22px;
    color: #4c4c4c;
}

/* Accounts Receivable */
.amount {
    font-size: 32px;
    font-weight: 700;
    margin: 10px 0;
}

.sub-info {
    color: #555;
    font-size: 14px;
}

.bold {
    font-weight: 600;
}

/* Monthly Rent UI */
.rent-controls {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 10px;
}

.rent-controls select,
.rent-controls input {
    padding: 10px;
    border: 1px solid #dcdcdc;
    border-radius: 12px;
    font-size: 14px;
}

.edit-btn {
    background: #11CA00;
    color: #fff;
    border: none;
    padding: 8px 15px;
    width: 80px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
}

.edit-btn:hover {
    background: #0ea300;
}

/* Maintenance & Repairs */
.maintenance-entry {
    margin-top: 20px;
}

.entry-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
}

.entry-row .label {
    font-weight: 600;
}
    </style>

 <div class="dash-grid">

        <!-- Active Tenant -->
        <div class="dash-box box-large">
            <div class="box-title">
                <i class='bx bx-user'></i> Active Tenant
            </div>
        </div>

        <!-- Accounts Receivable -->
        <div class="dash-box box-large">
            <div class="box-title">
                <i class='bx bx-wallet'></i> Accounts Receivable
            </div>

            <div class="amount">$100,000.00</div>
            <p class="sub-info">Accounts Unpaid:</p>
            <p class="sub-info bold">3 Accounts</p>
        </div>

        <!-- Monthly Rent -->
        <div class="dash-box box-medium">
            <div class="box-title">
                <i class='bx bx-dollar'></i> Monthly Rent
            </div>

            <div class="rent-controls">
                <select>
                    <option>------</option>
                </select>

                <input type="text" placeholder="Billing Account">

                <button class="edit-btn">Edit</button>
            </div>
        </div>

        <!-- Maintenance & Repairs -->
        <div class="dash-box box-medium">
            <div class="box-title">
                <i class='bx bx-wrench'></i> Maintenance & Repairs
            </div>

            <div class="maintenance-entry">
                <div class="entry-row">
                    <span class="label">Date</span>
                    <span>08-SEP-2005</span>
                </div>

                <div class="entry-row">
                    <span class="label">Nature</span>
                    <span>MAINTENANCE</span>
                </div>
            </div>
        </div>

    </div>

</div>





@endsection







