<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>

@include('layouts.navigation')

<div class="page-content">
    <h1>Edit Item</h1>

    <p class="subtext" style="margin-top:10px; margin-bottom:10px;">
        Update item details. Duplicate names are not allowed.
    </p>

    <!-- Success Message -->
    @if(session('success'))
        <div style="padding:10px; background:#d4edda; color:#155724; border-radius:8px; margin:20px 0;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if ($errors->any())
        <div style="padding:10px; background:#f8d7da; color:#721c24; border-radius:8px; margin:20px 0;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="form-card">

        <form method="POST" action="{{ route('item.update', $item->item_id) }}" enctype="multipart/form-data">

            @csrf
            @method('PUT')
            <!-- Item Name -->
            <div class="form-group">
                <label for="item_name" class="form-label">Item Name</label>
                <input type="text" name="item_name" id="item_name" value="{{ old('item_name', $item->item_name) }}" required class="form-input">
            </div>

            <!-- Currency -->
            <div class="form-group">
                <label for="currency" class="form-label">Currency</label>

                <select name="currency" id="currency" class="form-input">
                    @foreach($currencies as $currency)
                        <option value="{{ $currency->currency }}"
                            {{ $item->currency == $currency->currency ? 'selected' : '' }}>
                            {{ $currency->currency }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-input">
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}"
                            {{ $item->category_id == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="subcategory_id" class="form-label">Sub Category</label>
                <select name="subcategory_id" id="subcategory_id" class="form-input">
                    @foreach($subcategories as $subcategory)
                        <option value="{{ $subcategory->subcategory_id }}"
                            {{ $item->subcategory_id == $subcategory->subcategory_id ? 'selected' : '' }}>
                            {{ $subcategory->subcategory_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-input">{{ old('description', $item->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $item->price) }}" class="form-input">
            </div>

            <div class="form-group">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number"  min="0" step="1" name="quantity" id="quantity" value="{{ old('quantity', $item->quantity) }}" class="form-input">
            </div>

            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-input">
                    <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Deactive</option>
                </select>
            </div>

            <!-- Item Image -->
            <div class="form-group">
                <label for="image" class="form-label">Item Image</label>
                <input type="file" name="image" id="image" class="form-input">
                @if($item->image)
                    <div style="margin-top:10px;">
                        <img src="{{ asset('images/uploads/'.$item->image) }}" width="90" style="border-radius:6px;">
                    </div>
                @endif
            </div>

            <!-- Buttons -->
            <div class="form-group" style="display:flex; justify-content:space-between;">
                <a href="{{ route('item.manage') }}" class="btn-link">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>

</div>

</body>
</html>