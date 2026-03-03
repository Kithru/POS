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

{{-- Navigation --}}
@include('layouts.navigation')

<div class="page-content">

    <div style="padding:25px; background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); margin-top:20px;">

        <h2 style="margin-bottom:20px;">Manage Sub Categories</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        <table style="width:100%; border-collapse:collapse; font-size:14px;">
            <thead>
                <tr style="background:#f5f5f5; text-align:center;">
                    <th style="padding:12px;">ID</th>
                    <th style="padding:12px; text-align:left;">Category</th>
                    <th style="padding:12px; text-align:left;">Subcategory</th>
                    <th style="padding:12px;">Status</th>
                    <th style="padding:12px;">Action</th>
                </tr>
            </thead>

            <tbody>
            @forelse($subcategories as $subcategory)
                <tr style="border-bottom:1px solid #eee; text-align:center;">
                    
                    <td style="padding:12px;">
                        {{ $subcategory->subcategory_id }}
                    </td>

                    <td style="padding:12px; text-align:left;">
                        {{ $subcategory->category->category_name ?? '-' }}
                    </td>

                    <td style="padding:12px; text-align:left;">
                        {{ $subcategory->subcategory_name }}
                    </td>

                    {{-- Status --}}
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

                    {{-- Action --}}
                    <td style="padding:12px;">
                        @if($subcategory->status == 1)
                            <a href="{{ route('subcategory.deactivate', $subcategory->subcategory_id) }}"
                               onclick="return confirm('Are you sure you want to deactivate this subcategory?')"
                               style="padding:6px 12px; background:#dc3545; color:#fff; border-radius:6px; text-decoration:none;">
                                <i class="fas fa-ban"></i> Deactivate
                            </a>
                        @else
                            <a href="{{ route('subcategory.activate', $subcategory->subcategory_id) }}"
                               onclick="return confirm('Do you want to activate this subcategory?')"
                               style="padding:6px 12px; background:#28a745; color:#fff; border-radius:6px; text-decoration:none;">
                                <i class="fas fa-check"></i> Activate
                            </a>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding:20px; text-align:center; color:#888;">
                        No subcategories found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

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