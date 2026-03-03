<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Sub Categories</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>

@include('layouts.navigation') 

<div style="padding:25px; background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1);">

    <h2 style="margin-bottom:20px;">Manage Sub Categories</h2>

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
                <td style="padding:12px;">{{ $subcategory->subcategory_id }}</td>

                <td style="padding:12px; text-align:left;">
                    {{ $subcategory->category->category_name ?? '' }}
                </td>

                <td style="padding:12px; text-align:left;">
                    {{ $subcategory->subcategory_name }}
                </td>

                <td style="padding:12px;">
                    @if($subcategory->status == 1)
                        <span style="background:#d4edda; color:#155724; padding:5px 10px; border-radius:20px; font-size:12px;">
                            Active
                        </span>
                    @else
                        <span style="background:#f8d7da; color:#721c24; padding:5px 10px; border-radius:20px; font-size:12px;">
                            Deactive
                        </span>
                    @endif
                </td>

                <td style="padding:12px;">
                    @if($subcategory->status == 1)
                        <a href="{{ route('subcategory.deactivate', $subcategory->subcategory_id) }}"
                           style="padding:6px 12px; background:#dc3545; color:#fff; border-radius:6px; text-decoration:none;">
                            Deactivate
                        </a>
                    @else
                        <a href="{{ route('subcategory.activate', $subcategory->subcategory_id) }}"
                           style="padding:6px 12px; background:#28a745; color:#fff; border-radius:6px; text-decoration:none;">
                            Activate
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

    <!-- Pagination -->
    <div style="margin-top:20px; display:flex; justify-content:center;">
        {{ $subcategories->links() }}
    </div>

</div>

@endsection