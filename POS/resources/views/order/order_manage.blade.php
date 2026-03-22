<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Items</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="{{ asset('css/navi.css') }}" rel="stylesheet">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ordermanage.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>

@include('layouts.navigation')

<div class="page-content">

    <h1>Manage Orders</h1>

    <div class="form-card">

        <form method="GET" action="{{ route('order.manage') }}" style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">

            <!-- Order Code -->
            <input type="text" name="order_code" placeholder="Search Order Code"
                value="{{ request('order_code') }}"
                style="padding:8px; border:1px solid #ccc; border-radius:6px;">

            <div style="display:flex; flex-direction:column;">
                <label style="font-size:13px; font-weight:600; margin-bottom:4px;">
                    Order Status
                </label>
                <select name="status" style="padding:8px; border:1px solid #ccc; border-radius:6px; min-width:150px;">
                    <option value="">All Status</option>
                    <option value="0" {{ request('status')==='0' ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ request('status')==='1' ? 'selected' : '' }}>Confirmed</option>
                    <option value="2" {{ request('status')==='2' ? 'selected' : '' }}>Preparing</option>
                    <option value="3" {{ request('status')==='3' ? 'selected' : '' }}>Handed Over</option>
                    <option value="4" {{ request('status')==='4' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Ordered Date From -->
            <div style="display:flex; flex-direction:column;">
                <label style="font-size:13px; font-weight:600; margin-bottom:4px;">
                    Ordered Date (From)
                </label>
                <input type="date" name="date_from"
                    value="{{ request('date_from') }}"
                    style="padding:8px; border:1px solid #ccc; border-radius:6px;">
            </div>

            <!-- Ordered Date To -->
            <div style="display:flex; flex-direction:column;">
                <label style="font-size:13px; font-weight:600; margin-bottom:4px;">
                    Ordered Date (To)
                </label>
                <input type="date" name="date_to"
                    value="{{ request('date_to') }}"
                    style="padding:8px; border:1px solid #ccc; border-radius:6px;">
            </div>

            <!-- Buttons -->
            <button type="submit" class="action-btn edit-btn">Filter</button>

            <a href="{{ route('order.manage') }}" class="action-btn delete-btn"
            style="text-decoration:none; display:flex; align-items:center;">
                Reset
            </a>
        </form>



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
                        <button onclick="openCancelModal('{{ route('order.update.status', $order->order_id) }}')" 
                                class="action-btn delete-btn">
                            Cancel
                        </button>
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
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:20px; text-align:center; color:#888;">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if ($orders->hasPages())
        <div style="display:flex; justify-content:center; margin-top:20px; gap:8px; flex-wrap:wrap;">
            @if ($orders->onFirstPage())
                <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888; cursor:not-allowed;">&laquo; Prev</span>
            @else
                <a href="{{ $orders->previousPageUrl() }}" style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none;">&laquo; Prev</a>
            @endif

            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                @if ($page == $orders->currentPage())
                    <span style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; font-weight:bold;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#4b0f3a; text-decoration:none;">{{ $page }}</a>
                @endif
            @endforeach

            @if ($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}" style="padding:8px 12px; border-radius:6px; background:#4b0f3a; color:#fff; text-decoration:none;">Next &raquo;</a>
            @else
                <span style="padding:8px 12px; border-radius:6px; background:#f0f0f0; color:#888; cursor:not-allowed;">Next &raquo;</span>
            @endif
        </div>
        @endif

    </div>
</div>

<!-- Modal: View Items -->
<div id="itemsModal" class="modal">
    <div class="modal-content">
        <h3>Order Details</h3>
            <div id="orderInfo">
                <div class="order-field">
                    <strong>Order Code</strong>
                    <span id="orderCode">--</span>
                </div>
                <div class="order-field">
                    <strong>Current Status</strong>
                    <span id="currentStatus">--</span>
                </div>
                <div class="order-field">
                    <strong>Order Added</strong>
                    <span id="orderAdded">--</span>
                </div>
                <div class="order-field">
                    <strong>Customer</strong>
                    <span id="customerName">--</span>
                </div>
            </div>
        <div id="statusTimeline" style="margin-bottom:15px; font-size:13px; background:#f9f9f9; padding:10px; border-radius:6px;">
            <strong>Status History:</strong>
            <ul id="statusHistory" style="margin:5px 0 0 0; padding-left:18px; list-style-type:disc;"></ul>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price (Rs)</th>
                    <th>Subtotal (Rs)</th>
                </tr>
            </thead>
            <tbody id="itemsContent"></tbody>
        </table>

        <br>
        <button onclick="closeModal()" class="action-btn edit-btn">Close</button>
    </div>
</div>

<!-- Modal: Cancel Order -->
<div id="cancelModal" class="modal">
    <div class="modal-content cancel-modal">
        <span class="close-icon" onclick="closeCancelModal()">&times;</span>
        <h3><i class="fas fa-exclamation-triangle"></i> Cancel Order</h3>
        <p class="cancel-warning">Are you sure you want to cancel this order? This action cannot be undone.</p>

        <form method="POST" id="cancelForm">
            @csrf
            <input type="hidden" name="status" value="4">
            <label for="cancel_reason">Reason for Cancellation</label>
            <textarea name="cancel_reason" id="cancel_reason" placeholder="Enter cancellation reason..." required> </textarea>

            <div class="modal-actions">
                <button type="button" onclick="closeCancelModal()" class="action-btn edit-btn">
                    Close
                </button> 
                <button type="submit" class="action-btn delete-btn">
                    Confirm Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function viewItems(orderId){
        fetch("{{ url('/orders/items') }}/" + orderId)
        .then(res => res.json())
        .then(data => {
            const order = data.order;
            const items = data.items;

            // --- Order Info ---
            document.getElementById('orderCode').textContent = order.order_code;
            document.getElementById('orderAdded').textContent = new Date(order.created_at).toLocaleString();
            document.getElementById('currentStatus').textContent = getStatusText(order.status);
            document.getElementById('customerName').textContent = order.customer_name || 'N/A';

            const statusHistoryEl = document.getElementById('statusHistory');
            const timelineBox = document.getElementById('statusTimeline');

            statusHistoryEl.innerHTML = '';

            const statuses = {
                0: 'Pending',
                1: 'Confirmed',
                2: 'Preparing',
                3: 'Handed Over',
                4: 'Cancelled'
            };

            //  CANCELLED ORDER UI
            if (order.status == 4) {

                // Light red background
                timelineBox.style.background = '#ffe5e5';

                // Ordered Date
                const orderedDate = order.status_times[0] 
                    ? new Date(order.status_times[0]).toLocaleString() 
                    : 'N/A';

                const li1 = document.createElement('li');
                li1.innerHTML = `(Ordered Date) Pending: ${orderedDate}`;
                statusHistoryEl.appendChild(li1);

                // Cancelled Date (RED)
                const cancelledDate = order.status_times[4] 
                    ? new Date(order.status_times[4]).toLocaleString() 
                    : 'N/A';

                const li2 = document.createElement('li');
                li2.innerHTML = `
                    <strong style="color:#d32f2f;">Cancelled:</strong> 
                    <span style="color:#d32f2f; font-weight:600;">${cancelledDate}</span>
                `;
                statusHistoryEl.appendChild(li2);

            } else {
                timelineBox.style.background = '#f9f9f9';

                for (const [key, val] of Object.entries(order.status_times)) {

                    // Skip cancelled
                    if (parseInt(key) === 4) continue;

                    let displayVal = val 
                        ? new Date(val).toLocaleString() 
                        : 'N/A';

                    const li = document.createElement('li');
                    if (parseInt(key) === 0) {
                        li.innerHTML = `(Ordered Date) Pending: ${displayVal}`;
                    } else {
                        li.textContent = `${statuses[key]}: ${displayVal}`;
                    }

                    statusHistoryEl.appendChild(li);
                }
            }

            // --- Items Table ---
            let html = '';
            let total = 0;

            items.forEach(item => {
                let price = parseFloat(item.price);
                let subtotal = item.quantity * price;
                total += subtotal;

                html += `<tr>
                    <td>${item.item_name}</td>
                    <td>${item.quantity}</td>
                    <td>${price.toFixed(2)}</td>
                    <td>${subtotal.toFixed(2)}</td>
                </tr>`;
            });

            html += `<tr class="total-row">
                <td colspan="3">Total:</td>
                <td>${total.toFixed(2)}</td>
            </tr>`;

            document.getElementById('itemsContent').innerHTML = html;

            // Show modal
            document.getElementById('itemsModal').style.display = 'flex';
        })
        .catch(err => { 
            console.error(err); 
            alert('Failed to fetch order items.'); 
        });
    }
    function getStatusText(status){
        switch(parseInt(status)){
            case 0: return 'Pending';
            case 1: return 'Confirmed';
            case 2: return 'Preparing';
            case 3: return 'Handed Over';
            case 4: return 'Cancelled';
            default: return 'Unknown';
        }
    }

    function closeModal() {
        document.getElementById('itemsModal').style.display = 'none';
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').style.display = 'none';
    }

    function openCancelModal(actionUrl) {
        const form = document.getElementById('cancelForm');
        form.action = actionUrl; 
        document.getElementById('cancelModal').style.display = 'flex';
    }

    document.getElementById('cancelForm').addEventListener('submit', function(){
        this.querySelector('button[type="submit"]').disabled = true;
    });

</script>

</body>
</html>