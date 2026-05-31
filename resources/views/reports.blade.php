{{-- resources/views/reports/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Reports')
@section('page_title', 'Reports')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Reports</li>
@endsection

@section('content')

    {{-- ── Filter Card ──────────────────────────────────────── --}}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter mr-1"></i> Filter Report
            </h3>
        </div>

        <form method="GET" action="{{ route('reports') }}">
            <div class="card-body">
                <div class="row">

                    {{-- From Date --}}
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="small font-weight-bold">From Date</label>
                            <input type="date" name="from_date" class="form-control form-control-sm"
                                   value="{{ request('from_date') }}">
                        </div>
                    </div>

                    {{-- To Date --}}
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="small font-weight-bold">To Date</label>
                            <input type="date" name="to_date" class="form-control form-control-sm"
                                   value="{{ request('to_date') }}">
                        </div>
                    </div>

                    {{-- Type --}}
                    <div class="col-6 col-sm-6 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label class="small font-weight-bold">Type</label>
                            <select name="type" class="form-control form-control-sm">
                                <option value="">All Types</option>
                                <option value="income"  {{ request('type') === 'income'  ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                        </div>
                    </div>

                    {{-- Category --}}
                    <div class="col-6 col-sm-6 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label class="small font-weight-bold">Category</label>
                            <select name="category_id" class="form-control form-control-sm">
                                <option value="">All</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label class="small font-weight-bold d-none d-md-block">&nbsp;</label>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary btn-sm flex-fill mr-1">
                                    <i class="fas fa-search mr-1"></i> Filter
                                </button>
                                <a href="{{ route('reports') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
    {{-- ── End Filter ──────────────────────────────────────── --}}


    {{-- ── Summary Cards ──────────────────────────────────── --}}
    <div class="row">

        <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box bg-success">
                <span class="info-box-icon d-flex align-items-center justify-content-center">
                    <i class="fas fa-arrow-up"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Income</span>
                    <span class="info-box-number">₹{{ number_format($totalIncome, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box bg-danger">
                <span class="info-box-icon d-flex align-items-center justify-content-center">
                    <i class="fas fa-arrow-down"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Expense</span>
                    <span class="info-box-number">₹{{ number_format($totalExpense, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box {{ $balance >= 0 ? 'bg-info' : 'bg-warning' }}">
                <span class="info-box-icon d-flex align-items-center justify-content-center">
                    <i class="fas fa-wallet"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Balance</span>
                    <span class="info-box-number">₹{{ number_format($balance, 2) }}</span>
                </div>
            </div>
        </div>

    </div>
    {{-- ── End Summary ──────────────────────────────────────── --}}


    {{-- ── Table Card ──────────────────────────────────────── --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-table mr-1"></i> Transactions
                <span class="badge badge-primary ml-1">{{ $transactions->count() }}</span>
            </h3>
            <div class="card-tools">
                <a href="{{ route('reports_excel', request()->query()) }}"
                   class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel mr-1"></i>
                    <span class="d-none d-sm-inline">Export Excel</span>
                </a>
            </div>
        </div>

        <div class="card-body p-0">

            {{-- Desktop Table (hidden on mobile) --}}
            <div class="d-none d-md-block">
                <table class="table table-bordered table-striped table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Payment Method</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $t)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $t->created_at->format('d M Y') }}</td>
                                <td>{{ $t->title }}</td>
                                <td>{{ $t->category->name ?? '-' }}</td>
                                <td>{{ $t->paymentMethod->name ?? '-' }}</td>
                                <td>
                                    @if($t->category?->type === 'income')
                                        <span class="badge badge-success">
                                            <i class="fas fa-arrow-up mr-1"></i> Income
                                        </span>
                                    @elseif($t->category?->type === 'expense')
                                        <span class="badge badge-danger">
                                            <i class="fas fa-arrow-down mr-1"></i> Expense
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">-</span>
                                    @endif
                                </td>
                                <td class="font-weight-bold {{ $t->category?->type === 'income' ? 'text-success' : 'text-danger' }}">
                                    ₹{{ number_format($t->amount, 2) }}
                                </td>
                                <td>
                                    <span class="badge {{ $t->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ ucfirst($t->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                    No transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- Desktop Footer Summary --}}
                    @if($transactions->count() > 0)
                    <tfoot>
                        <tr class="bg-light font-weight-bold">
                            <td colspan="6" class="text-right">Summary:</td>
                            <td colspan="2">
                                <span class="text-success mr-2">
                                    <i class="fas fa-arrow-up"></i>
                                    ₹{{ number_format($totalIncome, 2) }}
                                </span>
                                <span class="text-danger mr-2">
                                    <i class="fas fa-arrow-down"></i>
                                    ₹{{ number_format($totalExpense, 2) }}
                                </span>
                                <span class="{{ $balance >= 0 ? 'text-primary' : 'text-warning' }}">
                                    <i class="fas fa-wallet"></i>
                                    ₹{{ number_format($balance, 2) }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            {{-- Mobile Cards (visible only on mobile) --}}
            <div class="d-block d-md-none">
                @forelse($transactions as $index => $t)
                    <div class="border-bottom p-3">

                        {{-- Top Row: Date + Type badge --}}
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ $t->created_at->format('d M Y') }}
                            </small>
                            @if($t->category?->type === 'income')
                                <span class="badge badge-success">
                                    <i class="fas fa-arrow-up mr-1"></i> Income
                                </span>
                            @elseif($t->category?->type === 'expense')
                                <span class="badge badge-danger">
                                    <i class="fas fa-arrow-down mr-1"></i> Expense
                                </span>
                            @else
                                <span class="badge badge-secondary">-</span>
                            @endif
                        </div>

                        {{-- Title + Amount --}}
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="font-weight-bold">{{ $t->title }}</span>
                            <span class="font-weight-bold {{ $t->category?->type === 'income' ? 'text-success' : 'text-danger' }}">
                                ₹{{ number_format($t->amount, 2) }}
                            </span>
                        </div>

                        {{-- Category + Payment --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-tag mr-1"></i>
                                {{ $t->category->name ?? '-' }}
                                &nbsp;|&nbsp;
                                <i class="fas fa-credit-card mr-1"></i>
                                {{ $t->paymentMethod->name ?? '-' }}
                            </small>
                            <span class="badge {{ $t->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                {{ ucfirst($t->status) }}
                            </span>
                        </div>

                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-3x d-block mb-3"></i>
                        No transactions found.
                    </div>
                @endforelse

                {{-- Mobile Footer Summary --}}
                @if($transactions->count() > 0)
                    <div class="bg-light p-3">
                        <div class="d-flex justify-content-between font-weight-bold">
                            <span class="text-success">
                                <i class="fas fa-arrow-up mr-1"></i>
                                ₹{{ number_format($totalIncome, 2) }}
                            </span>
                            <span class="text-danger">
                                <i class="fas fa-arrow-down mr-1"></i>
                                ₹{{ number_format($totalExpense, 2) }}
                            </span>
                            <span class="{{ $balance >= 0 ? 'text-primary' : 'text-warning' }}">
                                <i class="fas fa-wallet mr-1"></i>
                                ₹{{ number_format($balance, 2) }}
                            </span>
                        </div>
                    </div>
                @endif
            </div>
            {{-- End Mobile Cards --}}

        </div>
    </div>
    {{-- ── End Table ────────────────────────────────────────── --}}

@endsection