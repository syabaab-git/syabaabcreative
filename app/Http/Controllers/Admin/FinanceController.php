<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $transactions = \App\Models\FinanceTransaction::with('order.user')->latest()->paginate(15);
        $totalIncome = \App\Models\FinanceTransaction::where('type', 'income')->sum('amount');
        $totalExpense = \App\Models\FinanceTransaction::where('type', 'expense')->sum('amount');
        return view('admin.finances.index', compact('transactions', 'totalIncome', 'totalExpense'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:1000',
            'transaction_date' => 'nullable|date',
            'invoice_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($request->hasFile('invoice_file')) {
            $validated['invoice_file'] = $request->file('invoice_file')->store('invoices', 'public');
        }

        $transaction = new \App\Models\FinanceTransaction();
        $transaction->type = $validated['type'];
        $transaction->amount = $validated['amount'];
        $transaction->description = $validated['description'];
        $transaction->invoice_file = $validated['invoice_file'] ?? null;
        
        $date = !empty($validated['transaction_date']) ? \Carbon\Carbon::parse($validated['transaction_date']) : now();
        $transaction->transaction_date = $date;
        $transaction->created_at = $date;
        $transaction->save();

        return redirect()->route('admin.finances.index')->with('status', 'Transaksi berhasil ditambahkan.');
    }
}
