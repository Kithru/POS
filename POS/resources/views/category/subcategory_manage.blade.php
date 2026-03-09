<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Sub Categories</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>

@include('layouts.navigation')

<div class="page-content">

    <div class="form-card">

        <h2 style="margin-bottom:20px;">Manage Sub Categories</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:6px; margin-bottom:15px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filters -->
        <form method="GET" action="{{ route('subcategory.manage') }}" class="filter-form" style="margin-bottom:20px;">
            <label>
                Category:
                <select name="category_id">
                    <option value="">All Categories</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}"
                            {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
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

            <a href="{{ route('subcategory.manage') }}" style="margin-left:25px;">
                <i class="fas fa-sync-alt"></i> Reset
            </a>
        </form>

        <table style="width:100%; border-collapse:collapse; font-size:14px;">
            <thead>
                <tr style="background:#f5f5f5; text-align:center;">
                    <th style="padding:12px;">#</th>
                    <th style="padding:12px; text-align:left;">Subcategory Code</th>
                    <th style="padding:12px; text-align:left;">Category</th>
                    <th style="padding:12px; text-align:left;">Subcategory</th>
                    <th style="padding:12px;">Status</th>
                    <th style="padding:12px;">Action</th>
                    <th style="padding:12px;">Edit</th>
                </tr>
            </thead>

            <tbody>
            @forelse($subcategories as $index => $subcategory)
                <tr style="border-bottom:1px solid #eee; text-align:center;">

                    <!-- Serial Number -->
                    <td style="padding:12px;">
                        {{ $subcategories->firstItem() + $index }}
                    </td>

                    <!-- Subcategory Code -->
                    <td style="padding:12px; text-align:left;">
                        {{ $subcategory->subcategory_code ?? '-' }}
                    </td>

                    <!-- Category Name -->
                    <td style="padding:12px; text-align:left;">
                        {{ $subcategory->category->category_name ?? '-' }}
                    </td>

                    <!-- Subcategory Name -->
                    <td style="padding:12px; text-align:left;">
                        {{ $subcategory->subcategory_name }}
                    </td>

                    <!-- Status -->
                    <td style="padding:12px;">
                        @if($subcategory->status == 1)
                            <span style="background:#d4edda; color:#155724; padding:5px 12px; border-radius:20px; font-size:12px;">
                                Active
                            </span>
                        @else
                            <span style="background:#f8d7da; color:#721c24; padding:5px 12px; border-radius:20px; font-size:12px;">
                                Deactive
                            </span>
                        @endif
                    </td>

                    <!-- Activate / Deactivate -->
                    <td style="padding:12px;">
                        @if($subcategory->status == 1)
                            <a href="{{ route('subcategory.deactivate', $subcategory->subcategory_id) }}"
                               onclick="return confirm('Are you sure you want to deactivate this subcategory?')"
                               class="action-btn delete-btn" style="text-decoration:none;">
                                <i class="fas fa-ban"></i> Deactivate
                            </a>
                        @else
                            <a href="{{ route('subcategory.activate', $subcategory->subcategory_id) }}"
                               onclick="return confirm('Do you want to activate this subcategory?')"
                               class="action-btn edit-btn" style="background:#28a745; text-decoration:none;">
                                <i class="fas fa-check"></i> Activate
                            </a>
                        @endif
                    </td>

                    <!-- Edit Column -->
                    <td style="padding:12px;">
                        @if($subcategory->status == 1)
                            <a href="{{ route('subcategory.edit', $subcategory->subcategory_id) }}"
                               class="action-btn edit-btn" style="text-decoration:none;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @else
                            <span class="action-btn" style="background:#e9ecef; color:#6c757d; font-size:13px;">
                                <i class="fas fa-lock"></i> Locked
                            </span>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding:20px; text-align:center; color:#888;">
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
                    <span class="pagination-disabled">&laquo; Prev</span>
                @else
                    <a href="{{ $subcategories->previousPageUrl() }}" class="pagination-link">&laquo; Prev</a>
                @endif

                @foreach ($subcategories->getUrlRange(1, $subcategories->lastPage()) as $page => $url)
                    @if ($page == $subcategories->currentPage())
                        <span class="pagination-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($subcategories->hasMorePages())
                    <a href="{{ $subcategories->nextPageUrl() }}" class="pagination-link">Next &raquo;</a>
                @else
                    <span class="pagination-disabled">Next &raquo;</span>
                @endif
            </div>
        @endif

    </div>

</div>

</body>
</html>