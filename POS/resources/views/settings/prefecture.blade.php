<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Prefecture</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all_min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/prefecture.css') }}" rel="stylesheet">
</head>

<body>

@include('layouts.navigation')

<div class="content page-content">

    <h1>Manage Prefecture</h1>

    @if(session('success'))
        <div style="padding:10px; background:#d4edda; color:#155724; border-radius:8px; margin-top:20px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('prefecture.save') }}" method="POST">
        @csrf

        <table style="width:100%; border-collapse:collapse; text-align:center;">
            <thead>
                <tr style="background:#f5f5f5;">
                    <th>#</th>
                    <th>Prefecture</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="prefecture-body">
                @foreach($prefectures as $pref)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        <input type="hidden" name="id[]" value="{{ $pref->prefecture_id }}">
                        <input type="text" name="prefecture[]" value="{{ $pref->name }}" required>
                    </td>

                    <td>
                        <input type="number" step="0.01" name="amount[]" value="{{ $pref->amount }}" required>
                    </td>

                    <td>
                        <!-- UPDATE -->
                        <button type="submit" style="border:none; background:none;">
                            <i class="fas fa-check" style="color:green;"></i>
                        </button>

                        <!-- DELETE -->
                        <a href="{{ route('prefecture.delete', $pref->prefecture_id) }}"
                           onclick="return confirm('⚠️ Warning: This action will permanently delete this prefecture and cannot be undone. Do you want to continue?')">
                            <i class="fas fa-times" style="color:red;"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <br>

        <!-- ADD NEW -->
        <div style="text-align:center;">
            <button type="button" onclick="addRow()">
                Add New Prefecture
            </button>
        </div>

        <br>

        <button type="submit">Save All</button>

    </form>
</div>

<script>
function addRow() {
    let table = document.getElementById('prefecture-body');

    let row = `
        <tr>
            <td>New</td>

            <td>
                <input type="hidden" name="id[]" value="">
                <input type="text" name="prefecture[]" required>
            </td>

            <td>
                <input type="number" step="0.01" name="amount[]" required>
            </td>

            <td>
                <!-- SAVE -->
                <button type="submit" style="border:none; background:none;">
                    <i class="fas fa-check" style="color:green;"></i>
                </button>

                <!-- REMOVE ROW -->
                <i class="fas fa-times" style="color:red; cursor:pointer;" 
                   onclick="this.closest('tr').remove()"></i>
            </td>
        </tr>
    `;

    table.insertAdjacentHTML('beforeend', row);
}
</script>

</body>
</html>