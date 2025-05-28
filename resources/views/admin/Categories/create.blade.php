@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-header">
        <h1>Add New Category</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn-add">Back to Categories</a>
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
    <form action="{{ route('admin.categories.store') }}" method="POST" style="max-width: 600px;">
        @csrf
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="name">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn-add">Save Category</button>
    </form>
</div>
@endsection