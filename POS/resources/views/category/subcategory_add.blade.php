<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subcategory Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>

@include('layouts.navigation')  

<div class="content page-content">

    <h1>Add New Subcategory</h1>
    <p style="margin-top:5px;">Manage subcategories here. Prevent duplicates for each category.</p>

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

    <!-- Add Subcategory Form -->
    <div class="form-card">
        <form action="{{ route('subcategory.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Select Category</label>
                <select name="category_id" required class="form-input">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Subcategory Name</label>
                <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" required class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-textarea">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn-primary">
                Add Subcategory
            </button>
        </form>
    </div>

    <!-- Subcategory Table -->
    <div style="padding:20px; border-radius:12px; background:#fff; box-shadow:0 4px 12px rgba(0,0,0,0.1); margin-top:30px;">
        <h2 style="margin-bottom:15px;">Existing Subcategories</h2>

        <table style="width:100%; border-collapse:collapse; margin-top:10px; font-size:14px;">
            <thead>
                <tr style="background:#f5f5f5; text-align:center;">
                    <th style="padding:12px; border-bottom:2px solid #ddd; width:8%;">ID</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd; text-align:left; width:20%;">Category</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd; text-align:left; width:22%;">Subcategory Name</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd; text-align:left; width:30%;">Description</th>
                     @if(session('user_level') == 1)
                    <th style="padding:12px; border-bottom:2px solid #ddd; width:10%;">Added Date</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd; width:10%;">Modified Date</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($subcategories as $subcategory)
                    <tr style="text-align:center; border-bottom:1px solid #eee;">
                        <td style="padding:12px;">{{ $subcategory->subcategory_id }}</td>
                        <td style="padding:12px; text-align:left;">{{ $subcategory->category->category_name ?? '' }}</td>
                        <td style="padding:12px; text-align:left;">{{ $subcategory->subcategory_name }}</td>
                        <td style="padding:12px; text-align:left;">{{ $subcategory->description }}</td>
                        @if(session('user_level') == 1)
                        <td style="padding:12px;"> {{ $subcategory->added_date ?? 'N/A' }} </td>
                        <td style="padding:12px;"> {{ $subcategory->modified_date ?? 'N/A' }}</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:20px; text-align:center; color:#888;">
                            No subcategories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Modern Pagination -->
        @if ($subcategories->hasPages())
            <div style="display:flex; justify-content:center; margin-top:20px; gap:8px; flex-wrap:wrap;">
                {{-- Previous Page Link --}}
                @if ($subcategories->onFirstPage())
                    <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888; cursor:not-allowed;">&laquo; Prev</span>
                @else
                    <a href="{{ $subcategories->previousPageUrl() }}" style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none; transition:0.2s;">&laquo; Prev</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($subcategories->getUrlRange(1, $subcategories->lastPage()) as $page => $url)
                    @if ($page == $subcategories->currentPage())
                        <span style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; font-weight:bold;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#4b0f3a; text-decoration:none; transition:0.2s;">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($subcategories->hasMorePages())
                    <a href="{{ $subcategories->nextPageUrl() }}" style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none; transition:0.2s;">Next &raquo;</a>
                @else
                    <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888; cursor:not-allowed;">Next &raquo;</span>
                @endif
            </div>
        @endif
    </div>

</div>

</body>
</html>