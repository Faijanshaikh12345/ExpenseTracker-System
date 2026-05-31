<?php
// app/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Build filtered query — only logged-in user's data
     */
    private function buildQuery(Request $request)
    {
        $query = Transaction::with(['category', 'paymentMethod'])
            ->where('user_id', Auth::id());

        // Filter by type via category type
        if ($request->filled('type')) {
            $query->whereHas('category', fn($q) =>
                $q->where('type', $request->type)
            );
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by from date ✅ using created_at
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        // Filter by to date ✅ using created_at
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        return $query->orderBy('created_at', 'desc'); // ✅ using created_at
    }

    /**
     * Display report page
     */
    public function index(Request $request)
    {
        $transactions = $this->buildQuery($request)->get();

        $totalIncome  = $transactions->filter(fn($t) => $t->category?->type === 'income')->sum('amount');
        $totalExpense = $transactions->filter(fn($t) => $t->category?->type === 'expense')->sum('amount');
        $balance      = $totalIncome - $totalExpense;

        $categories = Category::where('user_id', Auth::id())
                               ->orderBy('name')
                               ->get();

        return view('reports', compact(
            'transactions', 'totalIncome', 'totalExpense', 'balance', 'categories'
        ));
    }

    /**
     * Export to Excel — no package needed!
     */
    public function exportExcel(Request $request)
    {
        $transactions = $this->buildQuery($request)->get();

        $totalIncome  = $transactions->filter(fn($t) => $t->category?->type === 'income')->sum('amount');
        $totalExpense = $transactions->filter(fn($t) => $t->category?->type === 'expense')->sum('amount');
        $balance      = $totalIncome - $totalExpense;

        $headers = [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="report_' . now()->format('Y_m_d') . '.xls"',
        ];

        $html = view('reports_excel', compact(
            'transactions', 'totalIncome', 'totalExpense', 'balance'
        ))->render();

        return response($html, 200, $headers);
    }
}