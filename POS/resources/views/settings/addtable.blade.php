<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Tables</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="{{ asset('css/table.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>

@include('layouts.navigation')

<div class="content page-content">

    <h1>Manage Tables</h1>

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
                    <th>Table No</th>
                    <th>Min Pax</th>
                    <th>Max Pax</th>
                    <th>Availability</th>
                    <th>Status</th>
                    <th width="350">Action</th>
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

                            <input class="form-input"
                                   type="text"
                                   name="table_number"
                                   value="{{ $table->table_number }}"
                                   required>
                        </td>

                        <td>
                            <input class="form-input"
                                   type="number"
                                   name="min_pax"
                                   value="{{ $table->min_pax }}"
                                   required>
                        </td>

                        <td>
                            <input class="form-input"
                                   type="number"
                                   name="max_pax"
                                   value="{{ $table->max_pax }}"
                                   required>
                        </td>

                        {{-- CHANGE STATUS --}}
                        @if($table->table_status == 1)

                            <a href="{{ route('table.deactivate', $table->id) }}"
                            class="action-btn"
                            style="
                                    text-decoration:none;
                                    background:#dc3545;
                                    color:white;
                            ">
                                Active
                            </a>

                        @else

                            <a href="{{ route('table.activate', $table->id) }}"
                            class="action-btn"
                            style="
                                    text-decoration:none;
                                    background:#28a745;
                                    color:white;
                            ">
                                Inactive
                            </a>

                        @endif



                        {{-- CHANGE AVAILABILITY --}}
                        @if($table->availability == 1)

                            <a href="{{ route('table.unavailable', $table->id) }}"
                            class="action-btn"
                            style="
                                    text-decoration:none;
                                    background:#17a2b8;
                                    color:white;
                            ">
                                Available
                            </a>

                        @else

                            <a href="{{ route('table.available', $table->id) }}"
                            class="action-btn"
                            style="
                                    text-decoration:none;
                                    background:#6c757d;
                                    color:white;
                            ">
                                Unavailable
                            </a>

                        @endif

                        <td style="display:flex; gap:8px; flex-wrap:wrap;">

                            {{-- UPDATE --}}
                            <button type="submit" class="action-btn edit-btn">
                                Update
                            </button>

                            {{-- STATUS --}}


                            @if($table->table_status == 1)

                                <a href="{{ route('table.status', $table->id) }}"
                                class="action-btn"
                                style="text-decoration:none;
                                        background:#28a745;
                                        color:white;
                                        display:inline-block;">
                                    Active
                                </a>

                            @else

                                <a href="{{ route('table.status', $table->id) }}"
                                class="action-btn"
                                style="text-decoration:none;
                                        background:#dc3545;
                                        color:white;
                                        display:inline-block; ">
                                    Inactive
                                </a>

                            @endif

                        </td>


                        {{-- AVAILABILITY --}}
                        <td>

                            @if($table->availability == 1)

                                <a href="{{ route('table.availability', $table->id) }}"
                                class="action-btn"
                                style="text-decoration:none;
                                        background:#17a2b8;
                                        color:white;
                                        display:inline-block;">
                                    Available
                                </a>

                            @else

                                <a href="{{ route('table.availability', $table->id) }}"
                                class="action-btn"
                                style=" text-decoration:none;
                                        background:#6c757d;
                                        color:white;
                                        display:inline-block;">
                                    Unavailable
                                </a>

                            @endif

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
                        <input type="hidden" name="id" value="">

                        <input class="form-input"
                               type="text"
                               name="table_number"
                               placeholder="Table Number"
                               required>
                    </td>

                    <td>
                        <input class="form-input"
                               type="number"
                               name="min_pax"
                               placeholder="Min Pax"
                               required>
                    </td>

                    <td>
                        <input class="form-input"
                               type="number"
                               name="max_pax"
                               placeholder="Max Pax"
                               required>
                    </td>

                    <td colspan="2">
                        <span style="color:gray;">
                            Default Active
                        </span>
                    </td>

                    <td>
                        <button type="submit" class="action-btn edit-btn">
                            Add Table
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