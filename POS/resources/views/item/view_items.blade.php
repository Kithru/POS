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

        <h2 style="margin-bottom:20px;">View Item Details</h2>

        <!-- Filters -->
        <form method="GET" action="{{ route('item.view') }}" class="filter-form" style="margin-bottom:20px;">
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

            <a href="{{ route('item.view') }}" style="margin-left:25px;">
                <i class="fas fa-sync-alt"></i> Reset
            </a>
        </form>

        <!-- Success Message -->
        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Items Table -->
        <table style="width:100%; border-collapse:collapse; font-size:14px;">
            <thead>
                <tr style="background:#f5f5f5; text-align:center;">
                    <th style="padding:12px;">#</th>
                    <th style="padding:12px; text-align:left;">Item Code</th>
                    <th style="padding:12px; text-align:left;">Item Name</th>
                    <th style="padding:12px; text-align:left;">Category</th>
                    <th style="padding:12px; text-align:left;">Subcategory</th>
                    <th style="padding:12px;">Price</th>
                    <th style="padding:12px;">Quantity</th>
                    <th style="padding:12px;">Status</th>
                    <th style="padding:12px;">Added Date</th>
                    <th style="padding:12px;">Modified Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse($items as $index => $item)
                    <tr style="border-bottom:1px solid #eee; text-align:center;">
                        <td style="padding:12px;">{{ $items->firstItem() + $index }}</td>
                        <td style="padding:12px; text-align:left;">{{ $item->item_code }}</td>
                        <td style="padding:12px; text-align:left;">{{ $item->item_name }}</td>
                        <td style="padding:12px; text-align:left;">{{ $item->category->category_name ?? '-' }}</td>
                        <td style="padding:12px; text-align:left;">{{ $item->subcategory->subcategory_name ?? '-' }}</td>
                        <td style="padding:12px;">{{ number_format($item->price,2) }}</td>
                        <td style="padding:12px;">{{ $item->quantity }}</td>
                        <td style="padding:12px;">
                            @if($item->status == 1)
                                <span style="background:#d4edda; color:#155724; padding:5px 12px; border-radius:20px; font-size:12px;">Active</span>
                            @else
                                <span style="background:#f8d7da; color:#721c24; padding:5px 12px; border-radius:20px; font-size:12px;">Deactive</span>
                            @endif
                        </td>
                        <td style="padding:12px;">{{ $item->created_at ?? 'N/A' }}</td>
                        <td style="padding:12px;">{{ $item->updated_at ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="padding:20px; text-align:center; color:#888;">No items found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if ($items->hasPages())
            <div style="display:flex; justify-content:center; margin-top:20px; gap:8px; flex-wrap:wrap;">

                @if ($items->onFirstPage())
                    <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888; cursor:not-allowed;">&laquo; Prev</span>
                @else
                    <a href="{{ $items->previousPageUrl() }}" style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none; transition:0.2s;">&laquo; Prev</a>
                @endif

                @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                    @if ($page == $items->currentPage())
                        <span style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; font-weight:bold;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#4b0f3a; text-decoration:none; transition:0.2s;">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($items->hasMorePages())
                    <a href="{{ $items->nextPageUrl() }}" style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none; transition:0.2s;">Next &raquo;</a>
                @else
                    <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888; cursor:not-allowed;">Next &raquo;</span>
                @endif
            </div>
        @endif

    </div>
</div>

</body>
</html>