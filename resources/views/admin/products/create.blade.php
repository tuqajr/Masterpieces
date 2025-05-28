@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="admin-header">
        <h1> + Add New Product</h1>
        <a href="{{ route('admin.products.index') }}" class="btn-back">Back to Products</a>
    </div>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="product-form">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
    <!-- Product name input -->
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="price">Price ($)</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required>
            </div>
            
            <div class="form-group">
    <label for="image">Product Image</label>
    <div class="custom-file-upload">
        <input type="file" id="image" name="image" accept="image/*" class="file-input" onchange="previewImage(this);">
        <label for="image" class="file-label">
            <span class="btn-upload">Choose File</span>
            <span class="file-name">No file chosen</span>
        </label>
    </div>
    
    <div class="image-preview-container">
        <div id="image-preview" class="image-preview">
            <span class="preview-text">Image Preview</span>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="extra_images">Extra Images</label>
    <input type="file" id="extra_images" name="extra_images[]" accept="image/*" multiple>
    <small>You can select multiple images</small>
</div>

            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn-save">Save Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .admin-header h1 {
        color: rgb(145, 51, 51);
        margin: 0;
    }
    
    .btn-back {
        background-color: #6c757d;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }
    
    .btn-back:hover {
        background-color: #5a6268;
    }
    
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    
    .alert-danger {
        background-color: #f2dede;
        color: #a94442;
        border: 1px solid #ebccd1;
    }
    
    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }
    
    .product-form {
        background-color: white;
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }
    
    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }
    
     .custom-file-upload {
        position: relative;
        display: inline-block;
        width: 100%;
        margin-bottom: 10px;
    }
    
    .file-input {
        position: absolute;
        left: -9999px;
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .file-label {
        display: flex;
        align-items: center;
        cursor: pointer;
        width: 100%;
        margin: 0;
    }
    
    .btn-upload {
        background-color: rgb(145, 51, 51);
        color: white;
        padding: 10px 15px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: normal;
        margin-right: 10px;
        transition: background-color 0.3s;
    }
    
    .btn-upload:hover {
        background-color: #d9534f;
    }
    
    .file-name {
        color: #555;
        font-weight: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .image-preview-container {
        margin-top: 15px;
    }
    
    .image-preview {
        width: 200px;
        height: 200px;
        border: 2px dashed #ddd;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 14px;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .preview-text {
        position: absolute;
        z-index: 1;
    }
    
    .image-preview.has-image .preview-text {
        display: none;
    }
    
    .form-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }
    
    .btn-save, .btn-cancel {
        padding: 12px 24px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
    }
    
    .btn-save {
        background-color: rgb(145, 51, 51);
        color: white;
        border: none;
        flex: 1;
    }
    
    .btn-save:hover {
        background-color: #d9534f;
    }
    
    .btn-cancel {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        color: #555;
        flex: 1;
    }
    
    .btn-cancel:hover {
        background-color: #e9ecef;
    }
</style>

<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const fileNameDisplay = input.nextElementSibling.querySelector('.file-name');
        
        // Update file name display
        if (input.files && input.files[0]) {
            fileNameDisplay.textContent = input.files[0].name;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.style.backgroundImage = `url(${e.target.result})`;
                preview.classList.add('has-image');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            fileNameDisplay.textContent = 'No file chosen';
            preview.style.backgroundImage = '';
            preview.classList.remove('has-image');
        }
    }
</script>
@endsection