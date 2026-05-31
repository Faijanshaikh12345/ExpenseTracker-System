{{-- resources/views/categories/show.blade.php --}}

@extends('layouts.app')

@section('title', 'View Payment')
@section('page_title', 'View Payment')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payment</a></li>
    <li class="breadcrumb-item active">View Payment</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">

                {{-- Card Header --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-tags mr-2"></i>  Payment Details
                    </h3>
                    <div>
                        <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-sm ml-1">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">

                        <tr>
                            <th style="width:200px; background:#f8f9fa;" class="pl-4">
                                <i class="fas fa-hashtag mr-2 text-muted"></i> ID
                            </th>
                            <td class="pl-4">{{ $payment->id }}</td>
                        </tr>

                        <tr>
                            <th style="background:#f8f9fa;" class="pl-4">
                                <i class="fas fa-tag mr-2 text-muted"></i> Name
                            </th>
                            <td class="pl-4">{{ $payment->name }}</td>
                        </tr>

                        <tr>
                            <th style="background:#f8f9fa;" class="pl-4">
                                <i class="fas fa-toggle-on mr-2 text-muted"></i> Status
                            </th>
                            <td class="pl-4">
                                @if($payment->status === 'active')
                                    <span class="badge badge-success px-2 py-1">
                                        <i class="fas fa-circle mr-1" style="font-size:.55rem"></i> Active
                                    </span>
                                @else
                                    <span class="badge badge-danger px-2 py-1">
                                        <i class="fas fa-circle mr-1" style="font-size:.55rem"></i> Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th style="background:#f8f9fa;" class="pl-4">
                                <i class="fas fa-calendar-plus mr-2 text-muted"></i> Created At
                            </th>
                            <td class="pl-4">{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                        </tr>

                        <tr>
                            <th style="background:#f8f9fa;" class="pl-4">
                                <i class="fas fa-calendar-check mr-2 text-muted"></i> Updated At
                            </th>
                            <td class="pl-4">{{ $payment->updated_at->format('d M Y, h:i A') }}</td>
                        </tr>

                    </table>
                </div>
                {{-- /.card-body --}}

                {{-- Card Footer --}}
                <div class="card-footer">
                    <form action="{{ route('payments.destroy', $payment->id) }}"
                          method="POST" class="d-inline"
                          id="delete-form-{{ $payment->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                                class="btn btn-danger btn-sm"
                                onclick="confirmDelete({{ $payment->id }})">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                    </form>
                </div>

            </div>
            {{-- /.card --}}
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this category?\nThis action cannot be undone.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush