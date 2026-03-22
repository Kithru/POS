<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Items</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
@push('styles')
    <style>
    .action-btn {
        padding: 6px 12px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        margin: 2px;
        font-size: 13px;
    }
    .edit-btn { background:#4b0f3a; color:#fff; }
    .delete-btn { background:#dc3545; color:#fff; }
    .modal { 
        position: fixed;
        z-index: 9999;
        left:0; top:0;
        width: 100%; height:100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background:#fff; 
        padding:20px; 
        border-radius:12px; 
        width:500px; 
        max-width:95%;
        max-height:80%;
        overflow-y:auto;
        box-shadow:0 4px 20px rgba(0,0,0,0.2);
    }
    </style>
@endpush
</head>

<body>
@push('scripts')
    <script>
        function viewItems(orderId) {
            // Generate base URL without ID
            let url = "{{ url('/orders/items') }}/" + orderId;

            fetch(url)
            .then(res => res.json())
            .then(data => {
                let html = '';
                let total = 0;
                data.forEach(item => {
                    let subtotal = item.quantity * item.price;
                    total += subtotal;
                    html += `
                        <tr>
                            <td style="padding:8px; border-bottom:1px solid #eee;">${item.item_name}</td>
                            <td style="padding:8px; border-bottom:1px solid #eee;">${item.quantity}</td>
                            <td style="padding:8px; border-bottom:1px solid #eee;">${item.price.toFixed(2)}</td>
                            <td style="padding:8px; border-bottom:1px solid #eee;">${subtotal.toFixed(2)}</td>
                        </tr>
                    `;
                });
                html += `
                    <tr style="font-weight:bold;">
                        <td colspan="3" style="padding:8px; text-align:right;">Total:</td>
                        <td style="padding:8px;">${total.toFixed(2)}</td>
                    </tr>
                `;
                document.getElementById('itemsContent').innerHTML = html;
                document.getElementById('itemsModal').style.display = 'flex';
            })
            .catch(err => {
                console.error(err);
                alert('Failed to fetch order items.');
            });
        }

        function closeModal() {
            document.getElementById('itemsModal').style.display = 'none';
        }
    </script>
@endpush

@include('layouts.navigation')

<div class="page-content">

    <h1>Manage Orders</h1>

    <div class="form-card">

        <!-- Success / Error Messages -->
        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:10px; border-radius:6px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:6px; margin-bottom:15px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- Orders Table -->
        <table style="width:100%; border-collapse:collapse; font-size:14px;">
            <thead>
                <tr style="background:#f5f5f5; text-align:center;">
                    <th style="padding:12px;">#</th>
                    <th style="padding:12px; text-align:left;">Order Code</th>
                    <th style="padding:12px; text-align:left;">Customer</th>
                    <th style="padding:12px;">View Items</th>
                    <th style="padding:12px;">Status</th>
                    <th style="padding:12px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $index => $order)
                <tr style="border-bottom:1px solid #eee; text-align:center;">
                    <td style="padding:12px;">{{ $orders->firstItem() + $index }}</td>
                    <td style="padding:12px; text-align:left;">{{ $order->order_code }}</td>
                    <td style="padding:12px; text-align:left;">{{ $order->customer_name }}</td>

                    <!-- View Items Button -->
                    <td style="padding:12px;">
                        <button onclick="viewItems({{ $order->order_id }})" class="action-btn edit-btn">
                            <i class="fas fa-eye"></i> View
                        </button>
                    </td>

                    <!-- Current Status -->
                    <td style="padding:12px; font-weight:bold;">
                        @if($order->status == 0)
                            <span style="color:#ff9800;">Pending</span>
                        @elseif($order->status == 1)
                            <span style="color:#009688;">Confirmed</span>
                        @elseif($order->status == 2)
                            <span style="color:#2196f3;">Preparing</span>
                        @elseif($order->status == 3)
                            <span style="color:#4caf50;">Handed Over</span>
                        @else
                            <span style="color:#f44336;">Cancelled</span>
                        @endif
                    </td>

                    <!-- Actions Buttons -->
                    <td style="padding:12px;">
                        @if($order->status == 0)
                        <form method="POST" action="{{ route('order.update.status', $order->order_id) }}" style="display:inline;">
                            @csrf
                            <input type="hidden" name="status" value="1">
                            <button class="action-btn edit-btn">Confirm</button>
                        </form>
                        @endif

                        @if($order->status == 1)
                        <form method="POST" action="{{ route('order.update.status', $order->order_id) }}" style="display:inline;">
                            @csrf
                            <input type="hidden" name="status" value="2">
                            <button class="action-btn edit-btn">Prepare</button>
                        </form>
                        @endif

                        @if($order->status == 2)
                        <form method="POST" action="{{ route('order.update.status', $order->order_id) }}" style="display:inline;">
                            @csrf
                            <input type="hidden" name="status" value="3">
                            <button class="action-btn edit-btn">Hand Over</button>
                        </form>
                        @endif

                        @if($order->status == 0)
                        <button onclick="openCancelModal({{ $order->order_id }})" class="action-btn delete-btn">
                            Cancel
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:20px; text-align:center; color:#888;">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if ($orders->hasPages())
            <div style="display:flex; justify-content:center; margin-top:20px; gap:8px; flex-wrap:wrap;">

                {{-- Previous Page --}}
                @if ($orders->onFirstPage())
                    <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888; cursor:not-allowed;">&laquo; Prev</span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}" style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none; transition:0.2s;">&laquo; Prev</a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                    @if ($page == $orders->currentPage())
                        <span style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; font-weight:bold;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#4b0f3a; text-decoration:none; transition:0.2s;">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page --}}
                @if ($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none; transition:0.2s;">Next &raquo;</a>
                @else
                    <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888; cursor:not-allowed;">Next &raquo;</span>
                @endif

            </div>
        @endif

    </div>
</div>

<!-- Modal: View Items -->
<div id="itemsModal" style="display:none;" class="modal">
    <div class="modal-content">
        <h3>Order Items</h3>
        <table id="itemsTable" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f5f5f5; text-align:left;">
                    <th style="padding:8px; border-bottom:1px solid #ccc;">Item Name</th>
                    <th style="padding:8px; border-bottom:1px solid #ccc;">Quantity</th>
                    <th style="padding:8px; border-bottom:1px solid #ccc;">Price (Rs)</th>
                    <th style="padding:8px; border-bottom:1px solid #ccc;">Subtotal (Rs)</th>
                </tr>
            </thead>
            <tbody id="itemsContent">
                <!-- Item rows will be appended here -->
            </tbody>
        </table>
        <br>
        <button onclick="closeModal()">Close</button>
    </div>
</div>

<!-- Modal: Cancel Order -->
<div id="cancelModal" style="display:none;" class="modal">
    <div class="modal-content">
        <h3>Cancel Order</h3>
        <form method="POST" id="cancelForm">
            @csrf
            <input type="hidden" name="status" value="4">
            <textarea name="cancel_reason" placeholder="Enter cancellation reason..." required></textarea>
            <br><br>
            <button type="submit" class="delete-btn">Submit</button>
            <button type="button" onclick="closeCancelModal()">Close</button>
        </form>
    </div>
</div>

</body>
</html>

