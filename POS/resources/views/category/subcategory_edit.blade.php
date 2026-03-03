<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Sub Category</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>

@include('layouts.navigation')

<div class="page-content">

    <div style="max-width:600px; margin:30px auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);">

        <h2 style="margin-bottom:20px;">Edit Sub Category</h2>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div style="background:#f8d7da; color:#721c24; padding:12px; border-radius:6px; margin-bottom:15px;">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Edit Form --}}
        <form action="{{ route('subcategory.edit', $subcategory->subcategory_id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Category Dropdown --}}
            <div style="margin-bottom:18px;">
                <label style="font-weight:600;">Category</label>
                <select name="category_id"
                        style="width:100%; padding:10px; margin-top:6px; border-radius:6px; border:1px solid #ccc;">
                    
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}"
                            {{ $subcategory->category_id == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Subcategory Name --}}
            <div style="margin-bottom:18px;">
                <label style="font-weight:600;">Subcategory Name</label>
                <input type="text"
                       name="subcategory_name"
                       value="{{ old('subcategory_name', $subcategory->subcategory_name) }}"
                       style="width:100%; padding:10px; margin-top:6px; border-radius:6px; border:1px solid #ccc;">
            </div>

            {{-- Status --}}
            <div style="margin-bottom:20px;">
                <label style="font-weight:600;">Status</label>
                <select name="status"
                        style="width:100%; padding:10px; margin-top:6px; border-radius:6px; border:1px solid #ccc;">
                    <option value="1" {{ $subcategory->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $subcategory->status == 0 ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div style="display:flex; justify-content:space-between;">

                <a href="{{ route('subcategory.manage') }}"
                   style="padding:10px 18px; background:#6c757d; color:#fff; border-radius:6px; text-decoration:none;">
                    <i class="fas fa-arrow-left"></i> Back
                </a>

                <button type="submit"
                        style="padding:10px 18px; background:#007bff; color:#fff; border:none; border-radius:6px;">
                    <i class="fas fa-save"></i> Update
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>