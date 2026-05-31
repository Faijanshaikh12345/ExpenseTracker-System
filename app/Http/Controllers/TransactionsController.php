<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    /**
     * Display a listing of transactions.
     */
    public function index()
    {
        $transactions = Transaction::with(['category', 'paymentMethod'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('transactions', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->where('status', 'active')->get();
        $payments   = PaymentMethod::where('user_id', Auth::id())->where('status', 'active')->get();

        return view('create_transaction', compact('categories', 'payments'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'title'             => 'required',
            'amount'            => 'required|numeric|min:0',
            'status'            => 'required|in:active,inactive',
        ],[
            'category_id.required'       => 'Please select a category.',
            'payment_method_id.required' => 'Please select a payment method.',
            'title.required'             => 'Title is required.',
            'amount.required'            => 'Amount is required.',
            'status.required'            => 'Status is required.',
        ]);

        $validated['user_id'] = Auth::id();

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified transaction.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with(['category', 'paymentMethod'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('show_transaction', compact('transaction'));
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(string $id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        $categories  = Category::where('user_id', Auth::id())->where('status', 'active')->get();
        $payments    = PaymentMethod::where('user_id', Auth::id())->where('status', 'active')->get();

        return view('update_transaction', compact('transaction', 'categories', 'payments'));
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'category_id'       => 'required|exists:categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'title'             => 'required',
            'amount'            => 'required|numeric|min:0',
            'status'            => 'required|in:active,inactive',
        ],[
            'category_id.required'       => 'Please select a category.',
            'payment_method_id.required' => 'Please select a payment method.',
            'title.required'             => 'Title is required.',
            'amount.required'            => 'Amount is required.',
            'status.required'            => 'Status is required.',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}