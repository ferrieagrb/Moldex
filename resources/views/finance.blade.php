@extends('layout.layout')

@section('content')

@php
use App\Models\Bill;

// Get the latest bill for the logged-in user
$bill = Bill::where('user_id', auth()->id())->latest()->first();
@endphp

<div class="fn-content">
    <header>
        <p id="greetings">Finances</p>
    </header>
    <div class="fn-rows">
        <div class="fn-row1">
            <div class="fn-tile1">
                <div class="acc-pay">
                    @if($bill)
                        @php
                            $displayAmount = ($bill->status === 'paid') ? 0 : $bill->amount;
                        @endphp
                        <div class="fn-tile">
                            <p>Accounts Payable</p>
                            <strong>
                            <p id=amount>$<span id="bill-amount-{{ $bill->id }}">{{ $displayAmount }}</span></p>
                            <p><strong>Due:</strong> {{ \Carbon\Carbon::parse($bill->due_date)->format('F d, Y') }}</p>
                            </strong>
                        </div>
                    @else
                        <p>Amount: 0 pesos</p>
                    @endif
                </div>
                <div class="overpay">
                        <p>Overpayment</p>
                        <strong>
                        <p id=amount>$ 0.00</p>
                        </strong>
                </div>
                <div class="pay">
                    <p>Payment</p>
                    @if($bill)
                        @if($bill->status === 'unpaid' && $displayAmount > 0)
                                <button onclick="openPayModal({{ $bill->id }}, {{ $displayAmount }})">Pay</button>
                            @endif
                    @endif
                </div>
            </div>

            <!-- Pay Modal -->
            <div id="payModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
                <div style="background:white; padding:20px; border-radius:8px; width:300px; text-align:center;">
                    <h3>Pay Bill</h3>
                    <p>Amount due: $<span id="modal-bill-amount"></span></p>
                    <input type="number" id="payAmount" placeholder="Enter amount to pay" style="width:100%; margin-bottom:10px;" />
                    <button onclick="submitPayment()">Pay</button>
                    <button onclick="closePayModal()" style="margin-top:10px;">Cancel</button>
                </div>
            </div>
        </div>

        <div class="fn-row2">
            <div class="fn-tile2">
                <div class="electricity">
                    <p>Electricity</p>
                    <h2 id=amount>$ 0.00</h2>
                </div>
                <div class="water" style="margin-left:100px;">
                    <p>Water</p>
                    <h2 id=amount>$ 0.00</h2>
                </div>
                <div class="pays">
                    <p>Payment</p>
                    <button>Pay</button>
                </div>
            </div>
        </div>
        <div class="fn-row3">
            <div class="fn-tile3"></div>
        </div>
    </div>
</div>

<script>
let currentBillId = null;

function openPayModal(billId, amount) {
    currentBillId = billId;
    document.getElementById('modal-bill-amount').innerText = amount;
    document.getElementById('payAmount').value = amount;
    document.getElementById('payModal').style.display = 'flex';
}

function closePayModal() {
    document.getElementById('payModal').style.display = 'none';
}

function submitPayment() {
    let payAmount = parseFloat(document.getElementById('payAmount').value);

    if (!payAmount || payAmount <= 0) {
        alert('Please enter a valid amount.');
        return;
    }

    fetch(`/bills/${currentBillId}/pay`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ amount: payAmount })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`bill-amount-${currentBillId}`).innerText = data.new_amount;
            closePayModal();
            alert('Payment successful!');
        } else {
            alert(data.message || 'Payment failed');
        }
    });
}
</script>

@endsection
