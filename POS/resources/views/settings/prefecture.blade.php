<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Prefecture</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="{{ asset('css/prefecture.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>

@include('layouts.navigation')

<div class="content page-content">

    <h1>Manage Prefecture</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('prefecture.save') }}" method="POST">
        @csrf

        <div class="form-card">

            <table>
                <thead>
                    <tr>
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
                            <input class="form-input" type="text" name="prefecture[]" value="{{ $pref->prefecture_name }}" required>
                        </td>

                        <td>
                            <input class="form-input" type="number" step="0.01" name="amount[]" value="{{ $pref->amount }}" required>
                        </td>

                        <td>
                            <!-- UPDATE -->
                            @if($pref->prefecture_id)
                            <button type="submit" formaction="{{ route('prefecture.save') }}" class="action-btn edit-btn" title="Update this prefecture">
                                <i class="fas fa-check"></i>
                            </button>
                            @else
                            <button type="submit" class="action-btn edit-btn" title="Add this prefecture">
                                <i class="fas fa-plus"></i>
                            </button>
                            @endif

                            <!-- DELETE -->
                            <a href="{{ route('prefecture.delete', $pref->prefecture_id) }}"
                               class="action-btn delete-btn"
                               title="Delete this prefecture"
                               onclick="return confirm('⚠️ Are you sure you want to delete this prefecture? This action cannot be undone.')">
                                <i class="fas fa-times"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>

        </div>

        <!-- ADD NEW -->
        <div style="text-align:center;">
            <button type="button" class="btn-primary" onclick="addRow()">
                Add New Prefecture
            </button>
        </div>

    </form>
</div>

<script>
function addRow() {
    const table = document.getElementById('prefecture-body');

    if (!table) {
        console.error('Table body not found!');
        return;
    }

    const tr = document.createElement('tr');

    tr.innerHTML = `
        <td>New</td>

        <td>
            <input type="hidden" name="id[]" value="">
            <input class="form-input" type="text" name="prefecture[]" placeholder="Enter Prefecture" required>
        </td>

        <td>
            <input class="form-input" type="number" step="0.01" name="amount[]" placeholder="Enter Amount" required>
        </td>

        <td>
            <!-- SAVE -->
            <button type="submit" class="action-btn edit-btn" data-tooltip="Save">
                <i class="fas fa-check"></i>
            </button>

            <!-- REMOVE ROW -->
            <button type="button" class="action-btn delete-btn" data-tooltip="Remove row">
                <i class="fas fa-times"></i>
            </button>
        </td>`;

    table.appendChild(tr);

    const input = tr.querySelector('input[name="prefecture[]"]');
    if (input) {
        input.focus();
    }

    const deleteBtn = tr.querySelector('.delete-btn');
    deleteBtn.addEventListener('click', function () {
        tr.remove();
    });
}
</script>

</body>
</html>