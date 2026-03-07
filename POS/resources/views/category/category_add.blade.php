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

<div class="page-content">

    <h1>Add New Category</h1>
    <p style="margin-top:5px;">Manage categories here. Prevent duplicate names.</p>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="form-card" style="background:#d4edda; color:#155724;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if($errors->any())
        <div class="form-card" style="background:#f8d7da; color:#721c24;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">

        <form action="{{ route('category.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Category Name</label>
                <input type="text" name="category_name" value="{{ old('category_name') }}" required class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Category Code</label>
                <input type="text" name="category_code" value="{{ old('category_code') }}" required oninput="validateCategoryCode(this)" class="form-input">
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-textarea">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn-primary">
                Add Category
            </button>
        </form>
    </div>

    <div class="form-card">

        <h2 style="margin-bottom:15px;">Existing Categories</h2>
        <table style="width:100%; border-collapse:collapse;">

            <thead>
                <tr style="background:#f5f5f5; text-align:center;">
                    <th>ID</th>
                    <th style="text-align:left;">Category Name</th>
                    <th style="text-align:left;">Category Code</th>
                    <th style="text-align:left;">Description</th>
                    <th>Added Date</th>
                    <th>Modified Date</th>
                </tr>
            </thead>

            <tbody>

                @forelse($categories as $category)

                <tr style="border-bottom:1px solid #eee; text-align:center;">
                    <td> {{ $category->category_id }} </td>
                    <td style="text-align:left;"> {{ $category->category_name }} </td>
                    <td style="text-align:left;"> {{ $category->category_code }} </td>
                    <td style="text-align:left;"> {{ $category->description }}</td>
                    <td>{{ $category->added_date }} </td>
                    <td> {{ $category->modified_date ?? 'N/A' }}</td>
                </tr>

                @empty

                <tr>
                    <td colspan="6" style="text-align:center; color:#888;">
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