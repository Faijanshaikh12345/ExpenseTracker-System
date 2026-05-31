{{-- resources/views/categories/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Create Transaction')
@section('page_title', 'Create Transaction')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transactions</a></li>
    <li class="breadcrumb-item active">Create Transaction</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Transaction Information</h3>
                </div>

                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf

                    <div class="card-body">


                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Payment Method</label>
                            <select name="payment_method_id" class="form-control">
                                <option value="">Select Payment</option>
                                @foreach ($payments as $payment)
                                    <option value="{{ $payment->id }}">
                                        {{ $payment->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        {{-- Name --}}
                        <div class="form-group">
                            <label for="name">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter Title" value="{{ old('title') }}">
                            @error('title')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- amount --}}
                        <div class="form-group">
                            <label for="name">Amount <span class="text-danger">*</span></label>
                            <input type="text" name="amount" id="amount" class="form-control"
                                placeholder="Enter Amount" value="{{ old('amount') }}">
                            @error('amount')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="" disabled selected>-- Select Status --</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                        @error('status')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    {{-- /.card-body --}}

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save Transaction
                        </button>
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                    </div>

                </form>

            </div>
            {{-- /.card --}}
        </div>
    </div>

@endsection
