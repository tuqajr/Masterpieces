@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-header">
        <h1>Edit Category</h1>
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
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" style="max-width: 600px;">
        @csrf
        @method('PUT')
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="name">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>
        <button type="submit" class="btn-edit">Update Category</button>
    </form>
</div>
@endsection