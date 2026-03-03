<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Sub Category</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>

@include('layouts.navigation') {{-- Sidebar + Top Navbar --}}

<div class="page-content">

    <h1>Edit Sub Category</h1>
    <p class="subtext" style="margin-top:10px; margin-bottom:10px;">
        Update subcategory details. Duplicate names are not allowed.
    </p>

    <!-- -- Success Message -- -->
    @if(session('success'))
        <div style="padding:10px; background:#d4edda; color:#155724; border-radius:8px; margin-bottom:20px; margin-top:20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="padding:10px; background:#f8d7da; color:#721c24; border-radius:8px; margin-bottom:20px; margin-top:20px;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Edit Form --}}
    <div class="form-card">
        <form action="{{ route('subcategory.update', $subcategory->subcategory_id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Category Dropdown --}}
            <div class="form-group">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-input" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" 
                            {{ $subcategory->category_id == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Subcategory Name --}}
            <div class="form-group">
                <label for="subcategory_name" class="form-label">Subcategory Name</label>
                <input type="text"
                       name="subcategory_name"
                       id="subcategory_name"
                       value="{{ old('subcategory_name', $subcategory->subcategory_name) }}"
                       class="form-input"
                       required>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-input" required>
                    <option value="1" {{ $subcategory->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $subcategory->status == 0 ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="form-group" style="display:flex; justify-content:space-between;">
                <a href="{{ route('subcategory.manage') }}" class="btn-link">
                    <i class="fas fa-arrow-left"></i> Back
                </a>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>

        </form>
    </div>

</div>

</body>
</html>