<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Prefecture</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>

@include('layouts.navigation')

<div class="content page-content">

    <h1>Manage Prefecture</h1>

    <!-- Messages -->
    @if(session('success'))
        <div style="padding:10px; background:#d4edda; color:#155724; border-radius:8px; margin-top:20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background:#fff; padding:25px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); margin-top:20px;">

        <form action="{{ route('prefecture.save') }}" method="POST">
            @csrf

            <table style="width:100%; border-collapse:collapse; text-align:center;">
                
                <thead>
                    <tr style="background:#f5f5f5;">
                        <th style="padding:10px;">#</th>
                        <th style="padding:10px;">Prefecture</th>
                        <th style="padding:10px;">Amount</th>
                        <th style="padding:10px;">Action</th>
                    </tr>
                </thead>

                <tbody id="prefecture-body">
                    
                    @foreach($prefectures as $index => $pref)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <input type="text" name="prefecture[]" 
                                   value="{{ $pref->name }}" 
                                   class="form-input" required>
                        </td>

                        <td>
                            <input type="number" step="0.01" name="amount[]" 
                                   value="{{ $pref->amount }}" 
                                   class="form-input" required>
                        </td>

                        <td>
                            <button type="submit" name="update_id" value="{{ $pref->id }}" 
                                    style="border:none; background:none;">
                                <i class="fas fa-check" style="color:green;"></i>
                            </button>

                            <a href="{{ route('prefecture.delete', $pref->id) }}"
                               onclick="return confirm('Delete this prefecture?')">
                                <i class="fas fa-times" style="color:red;"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

            <br>

            <!-- Add New -->
            <div style="text-align:center;">
                <button type="button" onclick="addRow()" 
                        style="padding:8px 20px; border-radius:6px; border:1px solid #ccc;">
                    Add new prefecture
                </button>
            </div>

            <br>

            <button type="submit" class="btn-primary">
                Save All
            </button>

        </form>

    </div>

</div>

<script>
function addRow() {
    let table = document.getElementById('prefecture-body');

    let row = `
        <tr>
            <td>New</td>

            <td>
                <input type="text" name="prefecture[]" class="form-input" required>
            </td>

            <td>
                <input type="number" step="0.01" name="amount[]" class="form-input" required>
            </td>

            <td>
                <i class="fas fa-check" style="color:green;"></i>
                <i class="fas fa-times" style="color:red;" onclick="this.closest('tr').remove()"></i>
            </td>
        </tr>
    `;

    table.insertAdjacentHTML('beforeend', row);
}
</script>

</body>
</html>