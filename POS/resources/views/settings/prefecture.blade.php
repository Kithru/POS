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

    {{-- SUCCESS --}}
    @if(session('success'))
        <div style="padding:10px; background:#d4edda; color:#155724; border-radius:8px; margin:20px 0;">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
        <div style="padding:10px; background:#f8d7da; color:#721c24; border-radius:8px; margin:20px 0;">
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDATION --}}
    @if($errors->any())
        <div style="padding:10px; background:#f8d7da; color:#721c24; border-radius:8px; margin:20px 0;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="form-card">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Prefecture</th>
                    <th>Amount ( <i class="fas fa-yen-sign"></i> )</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="prefecture-body">

            {{-- EXISTING ROWS --}}
            @foreach($prefectures as $pref)

                <tr>
                    <form action="{{ route('prefecture.save') }}" method="POST">
                        @csrf

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <input type="hidden" name="id" value="{{ $pref->prefecture_id }}">

                            <input class="form-input" type="text"
                                   name="name"
                                   value="{{ $pref->prefecture_name }}"
                                   required>
                        </td>

                        <td>
                            <input class="form-input" type="number" step="0.01"
                                   name="amount"
                                   value="{{ $pref->amount }}"
                                   required>
                        </td>

                        <td>
                            <button type="submit" class="action-btn edit-btn">
                                Update
                            </button>

                            <a href="{{ route('prefecture.delete', $pref->prefecture_id) }}"
                               class="action-btn delete-btn"
                               style="text-decoration: none;"
                               onclick="return confirm('⚠️ Are you sure you want to delete this prefecture? This action cannot be undone.')">
                                Delete
                            </a>
                        </td>

                    </form>
                </tr>

            @endforeach

            {{-- ADD NEW ROW --}}
            <tr>
                <form action="{{ route('prefecture.save') }}" method="POST">
                    @csrf

                    <td>New</td>

                    <td>
                        <input type="hidden" name="id" value="">
                        <input class="form-input" type="text"
                               name="name"
                               placeholder="Enter Prefecture"
                               required>
                    </td>

                    <td>
                        <input class="form-input" type="number" step="0.01"
                               name="amount"
                               placeholder="Enter Amount"
                               required>
                    </td>

                    <td>
                        <button type="submit" class="action-btn edit-btn">
                            Add
                        </button>
                    </td>

                </form>
            </tr>

            </tbody>
        </table>
    </div>

</div>

</body>
</html>