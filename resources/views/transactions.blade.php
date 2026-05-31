{{-- resources/views/transactions/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Manage Transactions')
@section('page_title', 'Manage Transactions')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Transactions</li>
@endsection

@push('styles')
    <style>
        #transactionsTable thead th {
            background-color: #343a40;
            color: #ffffff;
            white-space: nowrap;
            vertical-align: middle;
        }

        .badge-status {
            font-size: .8rem;
            padding: .35em .65em;
            border-radius: .25rem;
        }

        .badge-active {
            background-color: #28a745;
            color: #fff;
        }

        .badge-inactive {
            background-color: #dc3545;
            color: #fff;
        }


        .btn-action {
            width: 30px;
            height: 30px;
            padding: 0;
            line-height: 30px;
            text-align: center;
        }

        div.dataTables_wrapper div.dataTables_filter input {
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: .375rem .75rem;
            margin-left: .5rem;
        }

        div.dataTables_wrapper div.dataTables_length select {
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }
    </style>
@endpush

@section('content')

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-exchange-alt mr-2"></i> All Transactions
                    </h3>
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Add Transaction
                    </a>
                </div>

                <div class="card-body">
                    <table id="transactionsTable" class="table table-bordered table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th style="width:50px">#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th style="width:100px">Status</th>
                                <th style="width:120px">Date</th>
                                <th style="width:110px" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $index => $transaction)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>{{ $transaction->title }}</td>

                                    <td>{{ $transaction->category->name ?? '-' }}</td>

                                    <td>
                                        @if ($transaction->category?->type === 'income')
                                            <span class="badge badge-success">
                                                <i class="fas fa-arrow-up mr-1"></i> Income
                                            </span>
                                        @elseif($transaction->category?->type === 'expense')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-arrow-down mr-1"></i> Expense
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">-</span>
                                        @endif
                                    </td>

                                    <td>{{ $transaction->paymentMethod->name ?? '-' }}</td>

                                    <td
                                        class="font-weight-bold {{ $transaction->category?->type === 'income' ? 'text-success' : 'text-danger' }}">
                                        ₹{{ number_format($transaction->amount, 2) }}
                                    </td>

                                    <td>
                                        @if ($transaction->status === 'active')
                                            <span class="badge badge-success">
                                                <i class="fas fa-circle mr-1" style="font-size:.55rem"></i> Active
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-circle mr-1" style="font-size:.55rem"></i> Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td>{{ $transaction->created_at->format('d M Y') }}</td>

                                    <td class="text-center">
                                        {{-- View --}}
                                        <a href="{{ route('transactions.show', $transaction->id) }}"
                                            class="btn btn-info btn-sm btn-action" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('transactions.edit', $transaction->id) }}"
                                            class="btn btn-warning btn-sm btn-action" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST"
                                            class="d-inline" id="delete-form-{{ $transaction->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-action" title="Delete"
                                                onclick="confirmDelete({{ $transaction->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                        No transactions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- /.card-body --}}

            </div>
            {{-- /.card --}}
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function() {
            $('#transactionsTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, 'All']
                ],
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    orderable: false,
                    searchable: false,
                    targets: [-1] // ✅ last column (Actions) — not sortable/searchable
                }],
                language: {
                    search: '',
                    searchPlaceholder: 'Search transactions...',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ transactions',
                    infoEmpty: 'No transactions available',
                    infoFiltered: '(filtered from _MAX_ total entries)',
                    zeroRecords: 'No matching transactions found',
                    emptyTable: 'No transactions found',
                    paginate: {
                        previous: '<i class="fas fa-chevron-left"></i>',
                        next: '<i class="fas fa-chevron-right"></i>'
                    }
                }
            });
        });

        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this transaction?\nThis action cannot be undone.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush
