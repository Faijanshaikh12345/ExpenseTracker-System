@extends('layouts.app')

@section('title', 'Manage Payments')
@section('page_title', 'Manage Payments')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Payments</li>
@endsection

@push('styles')
    <style>
        #paymentsTable thead th {
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

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-credit-card mr-2"></i>
                        All Payments
                    </h3>
                    <a href="{{ route('payments.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>
                        Add Payment
                    </a>
                </div>

                <div class="card-body">
                    <table id="paymentsTable" class="table table-bordered table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th style="width:50px">#</th>
                                <th>Name</th>
                                <th style="width:110px">Status</th>
                                <th style="width:130px">Created At</th>
                                <th style="width:115px" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $index => $payment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $payment->name }}</td>
                                    <td>
                                        @if ($payment->status === 'active')
                                            <span class="badge badge-status badge-active">
                                                <i class="fas fa-circle mr-1" style="font-size:.55rem"></i>Active
                                            </span>
                                        @else
                                            <span class="badge badge-status badge-inactive">
                                                <i class="fas fa-circle mr-1" style="font-size:.55rem"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->created_at->format('d M Y') }}</td>
                                    <td class="text-center">

                                        {{-- View --}}
                                        <a href="{{ route('payments.show', $payment->id) }}"
                                            class="btn btn-info btn-sm btn-action" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('payments.edit', $payment->id) }}"
                                            class="btn btn-warning btn-sm btn-action" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST"
                                            class="d-inline" id="delete-form-{{ $payment->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-action" title="Delete"
                                                onclick="confirmDelete({{ $payment->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        <i class="fas fa-inbox mr-2"></i> No payments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function () {
            $('#paymentsTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
                order: [[0, 'asc']],
                columnDefs: [{
                    orderable: false,
                    searchable: false,
                    targets: [4]   // ← fixed: 5 columns, Actions is index 4
                }],
                language: {
                    search: '',
                    searchPlaceholder: 'Search payments...',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ payments',
                    infoEmpty: 'No payments available',
                    infoFiltered: '(filtered from _MAX_ total entries)',
                    zeroRecords: 'No matching payments found',
                    emptyTable: 'No payments found',
                    paginate: {
                        previous: '<i class="fas fa-chevron-left"></i>',
                        next: '<i class="fas fa-chevron-right"></i>'
                    }
                }
            });
        });

        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this payment?\nThis action cannot be undone.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush