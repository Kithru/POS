<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Items</title>

<link href="{{ asset('css/navi.css') }}" rel="stylesheet">
<link href="{{ asset('css/content.css') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

</head>

<body>

@include('layouts.navigation')

<div class="page-content">

<div class="form-card">

<h2 style="margin-bottom:20px;">Manage Items</h2>

@if(session('success'))
<div style="background:#d4edda;padding:10px;border-radius:6px;margin-bottom:15px;">
{{ session('success') }}
</div>
@endif

<form method="GET" action="{{ route('item.manage') }}" style="margin-bottom:20px;">

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


<label style="margin-left:20px;">
Status:
<select name="status">

<option value="">All</option>

<option value="1" {{ request('status') === '1' ? 'selected' : '' }}>
Active
</option>

<option value="0" {{ request('status') === '0' ? 'selected' : '' }}>
Inactive
</option>

</select>
</label>

<button type="submit" style="margin-left:20px;">
<i class="fas fa-filter"></i> Filter
</button>

<a href="{{ route('item.manage') }}" style="margin-left:20px;">
<i class="fas fa-sync"></i> Reset
</a>

</form>


<table style="width:100%;border-collapse:collapse;font-size:14px;">

<thead>

<tr style="background:#f5f5f5;text-align:center;">

<th>#</th>
<th style="text-align:left;">Item Code</th>
<th style="text-align:left;">Item Name</th>
<th style="text-align:left;">Category</th>
<th style="text-align:left;">Subcategory</th>
<th>Price</th>
<th>Qty</th>
<th>Status</th>
<th>Action</th>
<th>Edit</th>

</tr>

</thead>

<tbody>

@forelse($items as $index => $item)

<tr style="border-bottom:1px solid #eee;text-align:center;">

<td>{{ $items->firstItem() + $index }}</td>

<td style="text-align:left;">
{{ $item->item_code }}
</td>

<td style="text-align:left;">
{{ $item->item_name }}
</td>

<td style="text-align:left;">
{{ $item->category->category_name ?? '-' }}
</td>

<td style="text-align:left;">
{{ $item->subcategory->subcategory_name ?? '-' }}
</td>

<td>
{{ number_format($item->price,2) }}
</td>

<td>
{{ $item->quantity }}
</td>


<td>

@if($item->status == 1)

<span style="background:#d4edda;color:#155724;padding:5px 10px;border-radius:20px;font-size:12px;">
Active
</span>

@else

<span style="background:#f8d7da;color:#721c24;padding:5px 10px;border-radius:20px;font-size:12px;">
Inactive
</span>

@endif

</td>


<td>

@if($item->status == 1)

<a href="{{ route('item.deactivate',$item->item_id) }}"
onclick="return confirm('Deactivate this item?')"
class="action-btn delete-btn">

<i class="fas fa-ban"></i> Deactivate

</a>

@else

<a href="{{ route('item.activate',$item->item_id) }}"
onclick="return confirm('Activate this item?')"
class="action-btn edit-btn"
style="background:#28a745;">

<i class="fas fa-check"></i> Activate

</a>

@endif

</td>


<td>

@if($item->status == 1)

<a href="{{ route('item.edit',$item->item_id) }}"
class="action-btn edit-btn">

<i class="fas fa-edit"></i> Edit

</a>

@else

<span style="background:#e9ecef;color:#6c757d;padding:6px 12px;border-radius:6px;font-size:13px;">
<i class="fas fa-lock"></i> Locked
</span>

@endif

</td>

</tr>

@empty

<tr>
<td colspan="10" style="text-align:center;padding:20px;color:#888;">
No Items Found
</td>
</tr>

@endforelse

</tbody>

</table>


{{ $items->links() }}

</div>

</div>

</body>
</html>