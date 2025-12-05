<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentHistory;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class BillingController extends Controller
{
    // Show create invoice form (admin)
    public function create()
    {
        // load all users to bill
        $users = User::orderBy('name')->get();
        return view('admin.invoice', compact('users'));
    }

    // Store invoice
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $bill = Bill::create([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => 'unpaid',
            'issued_by' => Auth::id(), // null if not authenticated as admin
        ]);

        return redirect()->back()->with('success', 'Invoice issued successfully.');
    }

    // Show bills for the logged in user (for dashboard)
    public function userBills()
    {
        $user = Auth::user(); // Retrieve user details
        if (! $user) { // ! means NOT so it becomes NOT $user or there is nothing inside the variable
            return []; // if it is null, it returns none
        }

        $bills = Bill::where('user_id', $user->id)->orderBy('due_date')->get();

        // If called directly as a view
        return view('partials.dashboard_bills', compact('bills'));
    }

    // Optional: mark a bill as paid (admin or user action)
    public function markPaid(Request $request, $id)
    {
        $bill = Bill::findOrFail($id); //Finds the user Logged in's Bill

        if ($bill->user_id !== Auth::id()) { 
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $amountPaid = $request->input('amount');

        if ($amountPaid <= 0) {
            return response()->json(['success' => false, 'message' => 'Invalid amount'], 400);
        }

        // Save payment history
        PaymentHistory::create([
            'user_id' => Auth::id(),
            'bill_id' => $bill->id,
            'amount_paid' => $amountPaid,
            'date_paid' => now(),
            'status' => 'Paid',
            'receipt_number' => '6767' . Str::upper(Str::random(8)),
        ]);

        if ($amountPaid >= $bill->amount) {
            $bill->markPaid(now());
            $newAmount = 0;
        } else {
            $bill->amount -= $amountPaid;
            $bill->save();
            $newAmount = $bill->amount;
        }

        return response()->json(['success' => true, 'new_amount' => $newAmount]);
    }

    public function paymentHistory()
    {
        $histories = PaymentHistory::where('user_id', Auth::id())->orderBy('date_paid', 'desc')->take(3)->get();
        return view('partials.payment_history', compact('histories'));
    }

    public function generateReceipt($id)
    {
        $payment = PaymentHistory::findOrFail($id);

        $pdf = PDF::loadView('receipt', compact('payment'));

        // Stream the PDF in the browser (opens in new tab)
        // Users can then use the PDF viewer's download button
        $fileName = 'Receipt_' . $payment->receipt_number . '.pdf';
        return $pdf->stream($fileName);
    }

    public function finance()
{
    $user = Auth::user();

    $bills = Bill::where('user_id', $user->id)
                 ->orderBy('due_date')
                 ->get();

    $histories = PaymentHistory::where('user_id', $user->id)
                               ->orderBy('date_paid', 'desc')
                               ->take(3)
                               ->get();

    return view('finance', compact('bills', 'histories'));
}

    public function paymentHistoryAjax()
    {
        $histories = PaymentHistory::where('user_id', Auth::id())
                                ->orderBy('date_paid', 'desc')
                                ->take(3)
                                ->get();

        // Return the same Blade partial rendered as HTML
        return view('partials.payment_history', compact('histories'))->render();
    }


}
