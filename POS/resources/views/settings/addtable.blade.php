<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Tables</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        .form-input{
            width: 100px;
        }

        .alert {
            padding: 10px 14px;
            border-radius: 6px;
            margin: 10px 0;
        }

        .alert-success {
            background: #e7f7ed;
            color: #1e7e34;
            border-left: 5px solid #28a745;
        }

        .alert-error {
            background: #fdecea;
            color: #b02a37;
            border-left: 5px solid #dc3545;
        }

        a, button {
            text-decoration: none !important;
        }
    </style>

</head>

<body>

@include('layouts.navigation')

<div class="content page-content">

    <h1>Manage Tables</h1>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
        <div class="alert alert-error">
            <i class="fa-solid fa-circle-xmark"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDATION --}}
    @if($errors->any())
        <div class="alert alert-error">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif


    <div class="form-card">

        <table>

            <thead>
            <tr>
                <th>#</th>
                <th>Table No</th>
                <th>Min Pax</th>
                <th>Max Pax</th>
                <th>Status</th>
                <th>Availability</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>

            {{-- EXISTING TABLES --}}
            @foreach($tables as $table)

                <tr>

                    <form action="{{ route('table.save') }}" method="POST">
                        @csrf

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <input type="hidden" name="id" value="{{ $table->id }}">
                            <input class="form-input" type="text" name="table_number"
                                   value="{{ $table->table_number }}" required>
                        </td>

                        <td>
                            <input class="form-input" type="number" name="min_pax"
                                   value="{{ $table->min_pax }}" required>
                        </td>

                        <td>
                            <input class="form-input" type="number" name="max_pax"
                                   value="{{ $table->max_pax }}" required>
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($table->table_status == 1)
                                <a href="{{ route('table.status', $table->id) }}"
                                   class="action-btn edit-btn"
                                   style="background:#28a745;">
                                    <i class="fa-solid fa-check"></i> Active
                                </a>
                            @else
                                <a href="{{ route('table.status', $table->id) }}"
                                   class="action-btn delete-btn"
                                   style="background:#dc3545;">
                                    <i class="fa-solid fa-xmark"></i> Inactive
                                </a>
                            @endif
                        </td>

                        {{-- AVAILABILITY --}}
                        <td>
                            @if($table->availability == 1)
                                <a href="{{ route('table.availability', $table->id) }}"
                                   class="action-btn edit-btn"
                                   style="background:#17a2b8;">
                                    <i class="fa-solid fa-circle-check"></i> Available
                                </a>
                            @else
                                <a href="{{ route('table.availability', $table->id) }}"
                                   class="action-btn delete-btn"
                                   style="background:#6c757d;">
                                    <i class="fa-solid fa-circle-xmark"></i> Unavailable
                                </a>
                            @endif
                        </td>

                        {{-- ACTION --}}
                        <td>
                            <button type="submit" class="action-btn edit-btn">
                                <i class="fa-solid fa-pen"></i> Update
                            </button>
                        </td>

                    </form>

                </tr>

            @endforeach


            {{-- ADD NEW TABLE --}}
            <tr>

                <form action="{{ route('table.save') }}" method="POST">
                    @csrf

                    <td>New</td>

                    <td>
                        <input class="form-input" type="text" name="table_number"
                               placeholder="Table Number" required>
                    </td>

                    <td>
                        <input class="form-input" type="number" name="min_pax"
                               placeholder="Min Pax" required>
                    </td>

                    <td>
                        <input class="form-input" type="number" name="max_pax"
                               placeholder="Max Pax" required>
                    </td>

                    {{-- EMPTY (DEFAULT ACTIVE) --}}
                    <td></td>

                    {{-- EMPTY (DEFAULT AVAILABLE) --}}
                    <td></td>

                    <td>
                        <button type="submit" class="action-btn edit-btn">
                            <i class="fa-solid fa-plus"></i> Add
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