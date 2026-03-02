@extends('layouts.app') <!-- Your main layout -->

@section('content')
<div class="content">
    <h1>Add New Category</h1>
    <p>Manage categories here. Prevents duplicate names.</p>

    <!-- Form to Add Category -->
    <div class="card" style="padding:20px; margin-bottom:30px; border-radius:12px; background:#fff; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
        @if(session('success'))
            <div style="padding:10px; background:#d4edda; color:#155724; border-radius:8px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="padding:10px; background:#f8d7da; color:#721c24; border-radius:8px; margin-bottom:15px;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('category.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:15px;">
                <label for="category_name">Category Name</label>
                <input type="text" name="category_name" id="category_name" value="{{ old('category_name') }}" required
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
            </div>

            <div style="margin-bottom:15px;">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">{{ old('description') }}</textarea>
            </div>

            <button type="submit" style="padding:12px 20px; background:#7a0f5c; color:#fff; border:none; border-radius:8px; cursor:pointer; transition:0.3s;">
                Add Category
            </button>
        </form>
    </div>

    <!-- Existing Categories Table -->
    <div class="card" style="padding:20px; border-radius:12px; background:#fff; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
        <h2>Existing Categories</h2>
        <table style="width:100%; border-collapse:collapse; margin-top:15px;">
            <thead>
                <tr style="background:#f0f0f0; text-align:left;">
                    <th style="padding:10px; border-bottom:1px solid #ddd;">ID</th>
                    <th style="padding:10px; border-bottom:1px solid #ddd;">Category Name</th>
                    <th style="padding:10px; border-bottom:1px solid #ddd;">Description</th>
                    <th style="padding:10px; border-bottom:1px solid #ddd;">Added Date</th>
                    <th style="padding:10px; border-bottom:1px solid #ddd;">Modified Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td style="padding:10px; border-bottom:1px solid #eee;">{{ $category->id }}</td>
                        <td style="padding:10px; border-bottom:1px solid #eee;">{{ $category->category_name }}</td>
                        <td style="padding:10px; border-bottom:1px solid #eee;">{{ $category->description }}</td>
                        <td style="padding:10px; border-bottom:1px solid #eee;">{{ $category->created_at->format('Y-m-d') }}</td>
                        <td style="padding:10px; border-bottom:1px solid #eee;">{{ $category->updated_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection