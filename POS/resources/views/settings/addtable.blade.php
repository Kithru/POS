<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Table</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>

@include('layouts.navigation')

<div class="content page-content">

    <h1>Add New Table</h1>
    <p style="margin-top:5px;">Add restaurant table details and reservation availability.</p>

    <!-- Success Message -->
    @if(session('success'))
    <div style="padding:10px; background:#d4edda; color:#155724; border-radius:8px; margin-bottom:20px; margin-top:20px;">
        {{ session('success') }}
    </div>
    @endif

    <!-- Error Message -->
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

    <!-- Add Table Form -->
    <div class="form-card">

        <form action="{{ route('table.save') }}" method="POST">
            @csrf

            <!-- Table Number -->
            <div class="form-group">
                <label class="form-label">Table Number</label>
                <input type="text" 
                       name="table_number" 
                       class="form-input"
                       value="{{ old('table_number') }}"
                       required>
            </div>

            <!-- Availability -->
            <div class="form-group">
                <label class="form-label">Availability</label>
                <select name="availability" class="form-input" required>
                    <option value="">- Select Availability -</option>
                    <option value="1" {{ old('availability') == '1' ? 'selected' : '' }}>
                        Available
                    </option>
                    <option value="0" {{ old('availability') == '0' ? 'selected' : '' }}>
                        Unavailable
                    </option>
                </select>
            </div>

            <!-- Table Status -->
            <div class="form-group">
                <label class="form-label">Table Status</label>
                <select name="table_status" class="form-input" required>
                    <option value="">- Select Status -</option>
                    <option value="Available">Available</option>
                    <option value="Reserved">Reserved</option>
                    <option value="Occupied">Occupied</option>
                    <option value="Cleaning">Cleaning</option>
                </select>
            </div>

            <!-- Reservation Start Time -->
            <div class="form-group">
                <label class="form-label">Reservation Start Time</label>
                <input type="datetime-local"
                       name="reservation_starttime"
                       class="form-input"
                       value="{{ old('reservation_starttime') }}">
            </div>

            <!-- Reservation End Time -->
            <div class="form-group">
                <label class="form-label">Reservation End Time</label>
                <input type="datetime-local"
                       name="reservation_endtime"
                       class="form-input"
                       value="{{ old('reservation_endtime') }}">
            </div>

            <!-- Max Pax -->
            <div class="form-group">
                <label class="form-label">Maximum Pax</label>
                <input type="number"
                       name="max_pax"
                       class="form-input"
                       min="1"
                       value="{{ old('max_pax') }}"
                       required>
            </div>

            <!-- Min Pax -->
            <div class="form-group">
                <label class="form-label">Minimum Pax</label>
                <input type="number"
                       name="min_pax"
                       class="form-input"
                       min="1"
                       value="{{ old('min_pax') }}"
                       required>
            </div>

            <button type="submit" class="btn-primary">
                Add Table
            </button>

        </form>

    </div>

    <!-- Existing Tables -->
    <div style="padding:20px; border-radius:12px; background:#fff; box-shadow:0 4px 12px rgba(0,0,0,0.1); margin-top:30px;">

        <h2 style="margin-bottom:15px;">Existing Tables</h2>

        <table style="width:100%; border-collapse:collapse; margin-top:10px; font-size:14px;">

            <thead>
                <tr style="background:#f5f5f5; text-align:center;">

                    <th style="padding:12px; border-bottom:2px solid #ddd;">#</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Table Number</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Availability</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Table Status</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Reservation Start</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Reservation End</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Max Pax</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Min Pax</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Created At</th>
                    <th style="padding:12px; border-bottom:2px solid #ddd;">Updated At</th>

                </tr>
            </thead>

            <tbody>

                @forelse($tables as $table)

                <tr style="text-align:center; border-bottom:1px solid #eee;">

                    <td style="padding:12px;">
                        {{ $loop->iteration + ($tables->currentPage() - 1) * $tables->perPage() }}
                    </td>

                    <td style="padding:12px;">
                        {{ $table->table_number }}
                    </td>

                    <td style="padding:12px;">

                        @if($table->availability == 1)
                            <span style="color:green;">Available</span>
                        @else
                            <span style="color:red;">Unavailable</span>
                        @endif

                    </td>

                    <td style="padding:12px;">
                        {{ $table->table_status }}
                    </td>

                    <td style="padding:12px;">
                        {{ $table->reservation_starttime ?? 'N/A' }}
                    </td>

                    <td style="padding:12px;">
                        {{ $table->reservation_endtime ?? 'N/A' }}
                    </td>

                    <td style="padding:12px;">
                        {{ $table->max_pax }}
                    </td>

                    <td style="padding:12px;">
                        {{ $table->min_pax }}
                    </td>

                    <td style="padding:12px;">
                        {{ $table->created_at }}
                    </td>

                    <td style="padding:12px;">
                        {{ $table->updated_at }}
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="10" style="padding:20px; text-align:center; color:#888;">
                        No tables found.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        <!-- Pagination -->
        @if ($tables->hasPages())

        <div style="display:flex; justify-content:center; margin-top:25px; gap:8px; flex-wrap:wrap;">

            @if ($tables->onFirstPage())
                <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888;">
                    &laquo; Prev
                </span>
            @else
                <a href="{{ $tables->previousPageUrl() }}"
                   style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none;">
                    &laquo; Prev
                </a>
            @endif

            @foreach ($tables->getUrlRange(1, $tables->lastPage()) as $page => $url)

                @if ($page == $tables->currentPage())

                    <span style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; font-weight:bold;">
                        {{ $page }}
                    </span>

                @else

                    <a href="{{ $url }}"
                       style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#4b0f3a; text-decoration:none;">
                        {{ $page }}
                    </a>

                @endif

            @endforeach

            @if ($tables->hasMorePages())

                <a href="{{ $tables->nextPageUrl() }}"
                   style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none;">
                    Next &raquo;
                </a>

            @else

                <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888;">
                    Next &raquo;
                </span>

            @endif

        </div>

        @endif

    </div>

</div>

</body>
</html>