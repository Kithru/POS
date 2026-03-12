<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Categories</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="{{ asset('css/navi.css') }}" rel="stylesheet">
<link href="{{ asset('css/content.css') }}" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>

/* page wrapper */

.page-content{
    margin-left:250px;
    padding:30px;
    margin-top:70px;
}

/* responsive table */

.table-wrapper{
    overflow-x:auto;
}

.category-table{
    width:100%;
    border-collapse:collapse;
    font-size:14px;
}

.category-table thead{
    background:#f5f5f5;
}

.category-table th,
.category-table td{
    padding:12px;
}

.category-table tr{
    border-bottom:1px solid #eee;
}

/* mobile responsive */

@media (max-width:768px){

    .page-content{
        margin-left:0;
        padding:20px;
    }

    .category-table{
        font-size:13px;
    }

    .action-btn{
        display:block;
        width:100%;
        margin-bottom:5px;
        text-align:center;
    }

}

</style>

</head>

<body>

@include('layouts.navigation')

<div class="page-content">

<h1>Manage Categories</h1>

<p style="margin-top:10px; margin-bottom:15px;">
View, edit, or delete existing categories below.
</p>

@if(session('success'))
<div style="padding:10px; background:#d4edda; color:#155724; border-radius:8px; margin-bottom:20px;">
{{ session('success') }}
</div>
@endif


<div class="form-card">

<div class="table-wrapper">

<table class="category-table">

<thead>
<tr>
<th>ID</th>
<th style="text-align:left;">Category Name</th>
<th style="text-align:left;">Category Code</th>
<th style="text-align:left;">Description</th>

@if(session('user_level') == 1)
<th>Added Date</th>
<th>Modified Date</th>
@endif

<th>Actions</th>
</tr>
</thead>

<tbody>

@forelse($categories as $category)

<tr>

<td>{{ $category->category_id }}</td>

<td style="text-align:left;">
{{ $category->category_name }}
</td>

<td style="text-align:left;">
{{ $category->category_code }}
</td>

<td style="text-align:left;">
{{ $category->description }}
</td>

@if(session('user_level') == 1)
<td>{{ $category->added_date }}</td>
<td>{{ $category->modified_date }}</td>
@endif

<td>

<a href="{{ route('category.edit',$category->category_id) }}" class="action-btn edit-btn">
<i class="fas fa-pen"></i> Edit
</a>

<form action="{{ route('category.destroy',$category->category_id) }}" method="POST" style="display:inline-block;">
@csrf
@method('DELETE')

<button type="submit" class="action-btn delete-btn"
onclick="return confirm('Are you sure you want to delete this category?');">

<i class="fas fa-trash"></i> Delete

</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" style="padding:20px; text-align:center; color:#888;">
No categories found.
</td>
</tr>

@endforelse

</tbody>
</table>

</div>
</div>

</div>

</body>
</html>