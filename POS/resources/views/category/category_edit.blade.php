<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>

@include('layouts.navigation') 

<div class="page-content">

    <h1>Edit Category</h1>
    <p class="subtext" style="margin-top:10px; margin-bottom:10px;">Update category details. Duplicate names are not allowed.</p>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->

    @if($errors->any())
        <div style="padding:10px; background:#f8d7da; color:#721c24; border-radius:8px; margin-bottom:20px; margin-top:20px;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Edit Category Form -->
    <div class="form-card">
        <form action="{{ route('category.update', $category->category_id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" name="category_name" id="category_name"
                       value="{{ old('category_name', $category->category_name) }}"
                       required
                       class="form-input">
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="3" class="form-textarea">{{ old('description', $category->description) }}</textarea>
            </div>

            <button type="submit" class="btn-primary">Update Category</button>
        </form>
    </div>

    <a href="{{ route('category.manage') }}" class="btn-link">
        <i class="fas fa-arrow-left"></i> Back to Manage Categories
    </a>

</div>

</body>
</html>