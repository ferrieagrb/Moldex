<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        if (! $user) {
            return [];
        }

        $bills = Bill::where('user_id', $user->id)->orderBy('due_date')->get();

        // If called directly as a view
        return view('partials.dashboard_bills', compact('bills'));
    }

    // Optional: mark a bill as paid (admin or user action)
    public function markPaid(Request $request, $id)
{
    $bill = Bill::findOrFail($id);

    if ($bill->user_id !== Auth::id()) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    $amountPaid = $request->input('amount');
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

}
