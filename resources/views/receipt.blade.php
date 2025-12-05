<h2>Payment Receipt</h2>
<p>Receipt #: {{ $payment->receipt_number }}</p>
<p>Tenant: {{ $payment->user->name }}</p>
<p>Amount Paid: ₱{{ number_format($payment->amount_paid, 2) }}</p>
<p>Date Paid: {{ $payment->date_paid }}</p>
<p>Status: {{ $payment->status }}</p>
