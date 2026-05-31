<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $payments = PaymentMethod::where('user_id', Auth::id())->latest()->get();
        return view('payments', compact('payments'));
    }

    public function create()
    {
        return view('create_payment');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required'   => 'Payment name is required.',
            'status.required' => 'Payment status is required.',
        ]);

        PaymentMethod::create([
            'user_id' => Auth::id(),
            'name'    => $request->name,
            'status'  => $request->status,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment method created successfully.');
    }

    public function show(string $id)
    {
        $payment = PaymentMethod::where('user_id', Auth::id())->findOrFail($id);
        return view('show_payment', compact('payment'));
    }

    public function edit(string $id)
    {
        $payment = PaymentMethod::where('user_id', Auth::id())->findOrFail($id);
        return view('update_payment', compact('payment'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'   => 'required',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required'   => 'Payment name is required.',
            'status.required' => 'Payment status is required.',
        ]);

        $payment = PaymentMethod::where('user_id', Auth::id())->findOrFail($id);
        $payment->update([
            'name'   => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment method updated successfully.');
    }

    public function destroy(string $id)
    {
        $payment = PaymentMethod::where('user_id', Auth::id())->findOrFail($id);
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}