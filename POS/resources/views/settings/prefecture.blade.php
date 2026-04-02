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
                            <button type="submit" class="action-btn edit-btn">
                                <i class="fas fa-check"></i>
                            </button>

                            <!-- DELETE -->
                            <a href="{{ route('prefecture.delete', $pref->prefecture_id) }}"
                               class="action-btn delete-btn"
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
    let table = document.getElementById('prefecture-body');

    let row = `
        <tr>
            <td>New</td>

            <td>
                <input type="hidden" name="id[]" value="">
                <input class="form-input" type="text" name="prefecture[]" required>
            </td>

            <td>
                <input class="form-input" type="number" step="0.01" name="amount[]" required>
            </td>

            <td>
                <!-- SAVE -->
                <button type="submit" class="action-btn edit-btn">
                    <i class="fas fa-check"></i>
                </button>

                <!-- REMOVE ROW -->
                <button type="button" class="action-btn delete-btn" onclick="this.closest('tr').remove()">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>
    `;

    table.insertAdjacentHTML('beforeend', row);
}
</script>

</body>
</html>