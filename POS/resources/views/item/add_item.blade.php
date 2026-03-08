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

    <h1>Add New Item</h1>
    <p style="margin-top:5px;">Add product details, stock, and image.</p>

    <!-- Success Message -->
    @if(session('success'))
    <div style="padding:10px; background:#d4edda; color:#155724; border-radius:8px; margin-bottom:20px; margin-top:20px;">
        {{ session('success') }}
    </div>
    @endif

    <!-- Custom Error Message -->
    @if(session('error'))
    <div style="padding:10px; background:#f8d7da; color:#721c24; border-radius:8px; margin-bottom:20px; margin-top:20px;">
        {{ session('error') }}
    </div>
    @endif

    <!-- Validation Errors -->
    @if($errors->any())
    <div style="padding:10px; background:#f8d7da; color:#721c24; border-radius:8px; margin-bottom:20px; margin-top:20px;">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    <!-- Add Item Form -->
    <div class="form-card">
        <form action="{{ route('item.save') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category_id" id="category_select" class="form-input">
                    <option value="">- Select Category -</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->category_id }}">
                            {{ $category->category_name }}
                        </option>
                    @endforeach

                </select>
            </div>


            <div class="form-group">
                <label class="form-label">Sub Category</label>
                <select name="subcategory_id" id="subcategory_select" class="form-input">
                    <option value="">- Select Sub Category -</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Item Name</label>
                <input type="text" name="item_name" class="form-input" value="{{ old('item_name') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Currency Type</label>
                <select name="currency" class="form-input" id="currency_select" onchange="updateCurrencyIcon()">
                    <option value="">- Select Currency -</option>
                    @foreach($currencies as $currency)
                        <option value="{{ $currency->currency_code }}" data-icon="{{ $currency->currency_icon }}" 
                            {{ old('currency_type') == $currency->currency_code ? 'selected' : '' }}>
                            {{ $currency->currency }} ({{ $currency->currency_icon }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-textarea">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Price (Per Unit)</label>
                <input type="number" step="0.01" name="price" class="form-input" value="{{ old('price') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-input" value="{{ old('quantity') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Countable</label>
                <select name="countable" class="form-input">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <!-- New Image Upload Field -->
            <div class="form-group">
                <label class="form-label">Item Image</label>
                <label class="custom-file-upload">
                    <i class="fa fa-cloud-upload-alt"></i> Choose Image
                    <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
                </label>

                <div id="image-preview" style="margin-top:10px;">
                    <img id="preview-img" src="#" alt="Preview" style="display:none; width:100px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #ccc;">
                </div>
            </div>
            <button type="submit" class="btn-primary">
                Add Item
            </button>

        </form>
    </div>

    <!-- Item Table -->
    <div style="padding:20px; border-radius:12px; background:#fff; box-shadow:0 4px 12px rgba(0,0,0,0.1); margin-top:30px;">
        <h2 style="margin-bottom:15px;">Existing Items</h2>

        <table style="width:100%; border-collapse:collapse; margin-top:10px; font-size:14px;">
            <thead>
                <tr style="background:#f5f5f5; text-align:center;">
                    <th style="padding:12px; border-bottom:2px solid #ddd;">ID</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Item Code</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd; text-align:left;">Item Name</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Currency</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Price</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Quantity</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Status</th> <!-- NEW -->
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Image</th>

                    @if(session('user_level') == 1)
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Added Date</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Modified Date</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @forelse($items as $index => $item)
                <tr style="text-align:center; border-bottom:1px solid #eee;">
                    <td style="padding:12px;">
                        {{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}
                    </td>
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
                    @if(session('user_level') == 1)
                    <td style="padding:12px;">{{ $item->added_date }}</td>
                    <td style="padding:12px;">{{ $item->modified_date ?? 'N/A' }}</td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="padding:20px; text-align:center; color:#888;">
                        No items found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview-img');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    document.getElementById('category_select').addEventListener('change', function(){
        let category_id = this.value;
        if(category_id === ""){
            document.getElementById('subcategory_select').innerHTML =
            '<option value="">- Select Sub Category -</option>';
            return;
        }

        fetch('/get-subcategories/' + category_id)
        .then(response => response.json())
        .then(data => {

            let subcategorySelect = document.getElementById('subcategory_select');
            subcategorySelect.innerHTML = '<option value="">- Select Sub Category -</option>';

            data.forEach(function(sub){

                subcategorySelect.innerHTML += `
                    <option value="${sub.subcategory_id}">
                        ${sub.subcategory_name}
                    </option>
                `;
            });
        })
        .catch(error => console.log('Error:', error));
    });

</script>



</html>