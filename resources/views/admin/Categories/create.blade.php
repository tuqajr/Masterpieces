@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-header" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <h1 style="margin:0;">Add New Category</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back to Categories</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST" style="max-width:600px;">
        @csrf
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="name" class="form-label">Category Name <span style="color:red">*</span></label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name') }}" required maxlength="255" placeholder="e.g. Dresses, Accessories, Home Decor">
        </div>
        <button type="submit" class="btn btn-primary">Save Category</button>
    </form>
</div>
@endsection