<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Item Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>

@include('layouts.navigation')

<div class="page-content">

    <div style="padding:25px; background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); margin-top:20px;">

        <h2 style="margin-bottom:20px;">View Sub Categories</h2>

        <!-- Filters -->
        <form method="GET" action="{{ route('subcategory.view') }}" class="filter-form">
            <label>
                Category:
                <select name="category_id">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label style="margin-left:25px;">
                Status:
                <select name="status">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Deactive</option>
                </select>
            </label>

            <button type="submit" style="margin-left:25px;">
                <i class="fas fa-filter"></i> Filter
            </button>

            <a href="{{ route('subcategory.view') }}" style="margin-left:25px;">
                <i class="fas fa-sync-alt"></i> Reset
            </a>
        </form>

        <!-- Success Message -->
        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <table style="width:100%; border-collapse:collapse; font-size:14px;">
            <thead>
                <tr style="background:#f5f5f5; text-align:center;">
                    <th style="padding:12px;">#</th>
                    <th style="padding:12px; text-align:left;">Subcategory Code</th>
                    <th style="padding:12px; text-align:left;">Category</th>
                    <th style="padding:12px; text-align:left;">Subcategory</th>
                    <th style="padding:12px;">Status</th>
                    @if(session('user_level') == 1)
                        <th style="padding:12px;">Added Date</th>
                        <th style="padding:12px;">Modified Date</th>
                    @endif
                </tr>
            </thead>

            <tbody>
            @forelse($subcategories as $index => $subcategory)
                <tr style="border-bottom:1px solid #eee; text-align:center;">
                    <!-- Number -->
                    <td style="padding:12px;">{{ $subcategories->firstItem() + $index }}</td>

                    <!-- Subcategory Code -->
                    <td style="padding:12px; text-align:left;">{{ $subcategory->subcategory_code ?? '-' }}</td>

                    <!-- Category -->
                    <td style="padding:12px; text-align:left;">{{ $subcategory->category->category_name ?? '-' }}</td>

                    <!-- Subcategory Name -->
                    <td style="padding:12px; text-align:left;">{{ $subcategory->subcategory_name }}</td>

                    <!-- Status -->
                    <td style="padding:12px;">
                        @if($subcategory->status == 1)
                            <span style="background:#d4edda; color:#155724; padding:5px 12px; border-radius:20px; font-size:12px;">Active</span>
                        @else
                            <span style="background:#f8d7da; color:#721c24; padding:5px 12px; border-radius:20px; font-size:12px;">Deactive</span>
                        @endif
                    </td>

                    @if(session('user_level') == 1)
                        <td style="padding:12px;">{{ $subcategory->added_date ?? 'N/A' }}</td>
                        <td style="padding:12px;">{{ $subcategory->modified_date ?? 'N/A' }}</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ session('user_level') == 1 ? 7 : 5 }}" style="padding:20px; text-align:center; color:#888;">
                        No subcategories found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if ($subcategories->hasPages())
            <div style="display:flex; justify-content:center; margin-top:25px; gap:8px; flex-wrap:wrap;">
                
                @if ($subcategories->onFirstPage())
                    <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888;">&laquo; Prev</span>
                @else
                    <a href="{{ $subcategories->previousPageUrl() }}" style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none;">&laquo; Prev</a>
                @endif

                @foreach ($subcategories->getUrlRange(1, $subcategories->lastPage()) as $page => $url)
                    @if ($page == $subcategories->currentPage())
                        <span style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; font-weight:bold;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#4b0f3a; text-decoration:none;">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($subcategories->hasMorePages())
                    <a href="{{ $subcategories->nextPageUrl() }}" style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none;">Next &raquo;</a>
                @else
                    <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888;">Next &raquo;</span>
                @endif
            </div>
        @endif

    </div>

</div>

</body>
</html>