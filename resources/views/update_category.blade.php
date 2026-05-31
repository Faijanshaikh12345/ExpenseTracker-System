{{-- resources/views/categories/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Edit Category')
@section('page_title', 'Edit Category')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Edit Category</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Category Information</h3>
                </div>

                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        {{-- Name --}}
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter category name"
                                value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div class="form-group">
                            <label for="type">Type <span class="text-danger">*</span></label>

                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror"
                                required>

                                <option value="">Select Type</option>

                                <option value="income" {{ old('type', $category->type) == 'income' ? 'selected' : '' }}>
                                    Income
                                </option>

                                <option value="expense" {{ old('type', $category->type) == 'expense' ? 'selected' : '' }}>
                                    Expense
                                </option>

                            </select>

                            @error('type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                                required>
                                <option value="" disabled>-- Select Status --</option>
                                <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="inactive"
                                    {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                    {{-- /.card-body --}}

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Update Category
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                    </div>

                </form>

            </div>
            {{-- /.card --}}
        </div>
    </div>

@endsection
