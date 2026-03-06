<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Category Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>

@include('layouts.navigation')  

<div class="content page-content">

    <h1>Add New Category</h1>
    <p style="margin-top:5px;">Manage categories here. Prevent duplicate names.</p>

    <!-- Success Message -->
    @if(session('success'))
        <div style="padding:10px; background:#d4edda; color:#155724; border-radius:8px; margin-bottom:20px; margin-top:20px;">
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



    <!-- Add Category Form -->
    <div class="form-card">
        <form action="{{ route('category.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Category Name</label>
                <input type="text" name="category_name" value="{{ old('category_name') }}" required class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-textarea">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Category Code</label>
                <input type="text" name="category_code" value="{{ old('category_code') }}" required class="form-input" oninput="validateCategoryCode(this)">
            </div>

            </div>

            <button type="submit" class="btn-primary">
                Add Category
            </button>
        </form>
    </div>

    <!-- Category Table -->
    <div style="padding:20px; border-radius:12px; background:#fff; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
        <h2 style="margin-bottom:15px;">Existing Categories</h2>

        <table style="width:100%; border-collapse:collapse; margin-top:10px; font-size:14px;">
            <thead>
                <tr style="background:#f5f5f5; text-align:center;">
                    <th style="padding:12px; border-bottom:2px solid #ddd; width:8%;">ID</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd; text-align:left; width:22%;">Category Name</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd; text-align:left; width:30%;">Description</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd; text-align:left; width:22%;">category_code</th>
                    @if(session('user_level') == 1)
                    <th style="padding:12px; border-bottom:2px solid #ddd; width:20%;">Added Date</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd; width:20%;">Modified Date</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr style="text-align:center; border-bottom:1px solid #eee;">
                        <td style="padding:12px;">{{ $category->category_id }}</td>

                        <td style="padding:12px; text-align:left;">
                            {{ $category->category_name }}
                        </td>

                        <td style="padding:12px; text-align:left;">  
                            {{ $category->description }}
                        </td>

                        <td style="padding:12px; text-align:left;">
                            {{ $category->category_code }}
                        </td>
                        @if(session('user_level') == 1)
                            <td style="padding:12px;">
                                {{ $category->added_date }}
                            </td>

                            <td style="padding:12px;">
                                {{ $category->modified_date ?? 'N/A' }}
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:20px; text-align:center; color:#888;">
                            No categories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</body>

<script>
function validateCategoryCode(input) {
    let value = input.value;

    if (!/^[A-Z0-9]*$/.test(value)) {
        alert("Only CAPITAL letters and numbers are allowed.");
        input.value = value.replace(/[^A-Z0-9]/g, '');
    }
}
</script>

</html>