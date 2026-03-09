<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Item Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>

@include('layouts.navigation')

<div class="content page-content">

    <h1>Manage Items</h1>
    <p style="margin-top:5px;">Edit, update, or delete existing items.</p>

    <!-- Success / Error Messages -->
    @if(session('success'))
        <div style="padding:10px; background:#d4edda; color:#155724; border-radius:8px; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="padding:10px; background:#f8d7da; color:#721c24; border-radius:8px; margin-bottom:20px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search / Filter -->
    <form action="{{ route('item.manage') }}" method="GET" style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">
        <input type="text" name="search" class="form-input" placeholder="Search by name or code" value="{{ request('search') }}">
        <select name="status" class="form-input">
            <option value="">All Status</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="btn-primary"><i class="fa fa-search"></i> Search</button>
    </form>

    <!-- Items Table -->
    <div style="padding:20px; border-radius:12px; background:#fff; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
        <table style="width:100%; border-collapse:collapse; font-size:14px;">
            <thead>
                <tr style="background:#f5f5f5; text-align:center;">
                    <th style="padding:12px; border-bottom:2px solid #ddd;">ID</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Item Code</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd; text-align:left;">Item Name</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Currency</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Price</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Quantity</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Status</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Image</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $index => $item)
                    <tr style="text-align:center; border-bottom:1px solid #eee;">
                        <td style="padding:12px;">{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                        <td style="padding:12px;">{{ $item->item_code ?? 'N/A' }}</td>
                        <td style="padding:12px; text-align:left;">{{ $item->item_name }}</td>
                        <td style="padding:12px;">{{ $item->currency }}</td>
                        <td style="padding:12px;">{{ number_format($item->price,2) }}</td>
                        <td style="padding:12px;">{{ $item->quantity }}</td>
                        <td style="padding:12px;">
                            @if($item->status == 1)
                                <span style="color:green;">Active</span>
                            @else
                                <span style="color:red;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding:12px;">
                            @if($item->image)
                                <img src="{{ asset('images/uploads/'.$item->image) }}" alt="Item Image" style="width:50px; height:50px; object-fit:cover; border-radius:4px;">
                            @else
                                N/A
                            @endif
                        </td>
                        <td style="padding:12px; display:flex; justify-content:center; gap:5px;">
                            <a href="{{ route('item.edit', $item->item_id) }}" style="padding:6px 10px; background:#4b0f3a; color:#fff; border-radius:4px; text-decoration:none;">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('item.delete', $item->item_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="padding:6px 10px; background:#dc3545; color:#fff; border:none; border-radius:4px; cursor:pointer;">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="padding:20px; text-align:center; color:#888;">No items found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if ($items->hasPages())
            <div style="display:flex; justify-content:center; margin-top:25px; gap:8px; flex-wrap:wrap;">
                
                @if ($items->onFirstPage())
                    <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888;">&laquo; Prev</span>
                @else
                    <a href="{{ $items->previousPageUrl() }}" style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none;">&laquo; Prev</a>
                @endif

                @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                    @if ($page == $items->currentPage())
                        <span style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; font-weight:bold;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#4b0f3a; text-decoration:none;">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($items->hasMorePages())
                    <a href="{{ $items->nextPageUrl() }}" style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none;">Next &raquo;</a>
                @else
                    <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888;">Next &raquo;</span>
                @endif

            </div>
        @endif
    </div>
</div>

</body>
</html>