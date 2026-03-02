<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Category Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>

@include('layouts.navigation')  {{-- Your sidebar + top navbar --}}

<div class="content" style="margin-left:250px; padding:30px; margin-top:70px;">

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
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Add Category Form -->
    <div style="padding:20px; margin-bottom:30px; margin-top:15px; border-radius:12px; background:#fff; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
        <form action="{{ route('category.store') }}" method="POST">
            @csrf

            <div style="margin-bottom:15px;">
                <label>Category Name</label>
                <input type="text" name="category_name"
                       value="{{ old('category_name') }}"
                       required
                       style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
            </div>

            <div style="margin-bottom:15px;">
                <label>Description</label>
                <textarea name="description" rows="3"
                          style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">{{ old('description') }}</textarea>
            </div>

            <button type="submit"
                    style="padding:12px 20px; background:#7a0f5c; color:#fff; border:none; border-radius:8px; cursor:pointer;">
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
                    <th style="padding:12px; border-bottom:2px solid #ddd; width:20%;">Added Date</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd; width:20%;">Modified Date</th>
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

                        <td style="padding:12px;">
                            {{ $category->added_date }}
                        </td>

                        <td style="padding:12px;">
                            {{ $category->modified_date }}
                        </td>
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
</html>