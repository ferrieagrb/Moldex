<h3>Recent Payments</h3>
<table style="border-spacing:1em;" width="100%" cellpadding="5">
        <tr style="border-bottom: 2px solid #000000;">
            <td>Date Paid</td>
            <td>Amount</td>
            <td>Status</td>
            <td>Receipt</td>
        </tr>

        @forelse($histories as $payment)
        <tr>
            <td>{{ \Carbon\Carbon::parse($payment->date_paid)->format('F d, Y H:i') }}</td>
            <td>${{ number_format($payment->amount_paid, 2) }}</td>
            <td>{{ $payment->status }}</td>
            <td><a href="{{ route('receipt.generate', $payment->id) }}" target="_blank">View / Download</a></td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No recent payments</td>
        </tr>
        @endforelse

</table>
