{{-- resources/views/reports/excel.blade.php --}}
{{-- This renders as HTML table — Excel opens it perfectly --}}

<html>
<head>
    <meta charset="UTF-8">
    <style>
        body  { font-family: Arial, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th    { background-color: #343a40; color: #ffffff; padding: 8px; text-align: left; border: 1px solid #ccc; }
        td    { padding: 6px 8px; border: 1px solid #ccc; }
        tr:nth-child(even) td { background-color: #f2f2f2; }
        .summary td { font-weight: bold; background-color: #e9ecef; }
        .income  { color: green; }
        .expense { color: red; }
        .balance { color: navy; }
        h2 { font-size: 16px; margin-bottom: 4px; }
        p  { font-size: 11px; color: #666; margin-bottom: 12px; }
    </style>
</head>
<body>

    <h2>Transaction Report</h2>
    <p>Generated on: {{ now()->format('d M Y, h:i A') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Title</th>
                <th>Category</th>
                <th>Payment Method</th>
                <th>Type</th>
                <th>Amount (₹)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</td>
                <td>{{ $t->title }}</td>
                <td>{{ $t->category->name      ?? '-' }}</td>
                <td>{{ $t->paymentMethod->name ?? '-' }}</td>
                <td>{{ ucfirst($t->category?->type ?? '-') }}</td>
                <td>{{ number_format($t->amount, 2) }}</td>
                <td>{{ ucfirst($t->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;color:#999;">No records found.</td>
            </tr>
            @endforelse
        </tbody>

        {{-- Summary Footer --}}
        <tfoot>
            <tr class="summary">
                <td colspan="6" style="text-align:right;">Total Income:</td>
                <td colspan="2" class="income">₹{{ number_format($totalIncome, 2) }}</td>
            </tr>
            <tr class="summary">
                <td colspan="6" style="text-align:right;">Total Expense:</td>
                <td colspan="2" class="expense">₹{{ number_format($totalExpense, 2) }}</td>
            </tr>
            <tr class="summary">
                <td colspan="6" style="text-align:right;">Balance:</td>
                <td colspan="2" class="balance">₹{{ number_format($balance, 2) }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>