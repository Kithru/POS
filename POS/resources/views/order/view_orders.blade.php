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

    <h1>View Orders</h1>

    <div class="form-card">

        <form method="GET" action="{{ route('order.view') }}" style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">

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

            <a href="{{ route('order.view') }}" class="action-btn delete-btn"
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
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $index => $order)
                <tr style="border-bottom:1px solid #eee; text-align:center;">
                    <td style="padding:12px;">{{ $orders->firstItem() + $index }}</td>
                    <td style="padding:12px; text-align:left;">{{ $order->order_code }}</td>
                    <td style="padding:12px; text-align:left;">
                        {{ $order->customer->customer_first_name ?? '' }}
                        {{ $order->customer->customer_last_name ?? '' }}
                    </td>

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
                    <!-- <strong>Customer</strong> -->
                    <span id="customerDetails">--</span>
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
        <button onclick="printBill()" class="action-btn edit-btn"> <i class="fas fa-print"></i> Print </button>
        <button onclick="closeModal()" class="action-btn edit-btn">Close</button>
    </div>
</div>

<script>
function viewItems(orderId) {
    fetch("{{ url('/orders/items') }}/" + orderId)
        .then(res => {
            if (!res.ok) {
                throw new Error('HTTP error! Status: ' + res.status);
            }

            return res.json();
        })
        .then(data => {

            console.log('Order response:', data);

            const order = data.order;
            const items = data.items || [];

            if (!order) {
                throw new Error('Order data not found.');
            }

            // --------------------------------
            // Order Amount Values
            // --------------------------------
            const tax = parseFloat(order.tax || 0);
            const cod = parseFloat(order.cod_amount || 0);
            const totalPayable = parseFloat(order.total_amount || 0);
            const discount = parseFloat(order.discount || 0);

            // If box_amount exists in the database
            const boxAmount = parseFloat(order.box_amount || 0);


            // --------------------------------
            // Order Info
            // --------------------------------
            document.getElementById('orderCode').textContent =
                order.order_code || 'N/A';

            document.getElementById('orderAdded').textContent =
                order.created_at
                    ? new Date(order.created_at).toLocaleString()
                    : 'N/A';

            document.getElementById('currentStatus').textContent =
                getStatusText(order.status);


            // --------------------------------
            // Customer & Delivery Details
            // --------------------------------
            const customer = order.customer || {};
            const receiver = order.receiver || {};

            const customerHTML = `
                <div style="line-height:1.8; font-size:13px;">

                    <div style="margin-bottom:10px;">
                        <strong style="color:#4b0f3a;">
                            Customer Details
                        </strong>
                        <br>

                        <span>
                            <b>Name:</b>
                            ${customer.name || 'N/A'}
                        </span>
                        <br>

                        <span>
                            <b>Email:</b>
                            ${customer.email || 'N/A'}
                        </span>
                        <br>

                        <span>
                            <b>Phone:</b>
                            ${customer.phone || 'N/A'}
                        </span>
                    </div>


                    <div style="margin-top:20px;">
                        <strong style="color:#4b0f3a;">
                            Delivery Details
                        </strong>
                        <br>

                        <span>
                            <b>Name:</b>
                            ${receiver.name || 'N/A'}
                        </span>
                        <br>

                        <span>
                            <b>Email:</b>
                            ${receiver.email || 'N/A'}
                        </span>
                        <br>

                        <span>
                            <b>Phone:</b>
                            ${receiver.phone || 'N/A'}
                        </span>
                        <br>

                        <span>
                            <b>Address:</b>
                            ${receiver.address || 'N/A'}
                        </span>
                    </div>

                </div>
            `;

            document.getElementById('customerDetails').innerHTML =
                customerHTML;


            // --------------------------------
            // Status History
            // --------------------------------
            const statusHistoryEl =
                document.getElementById('statusHistory');

            const timelineBox =
                document.getElementById('statusTimeline');

            statusHistoryEl.innerHTML = '';

            const statuses = {
                0: 'Pending',
                1: 'Confirmed',
                2: 'Preparing',
                3: 'Handed Over',
                4: 'Cancelled'
            };

            const statusTimes = order.status_times || {};


            // --------------------------------
            // Cancelled Order
            // --------------------------------
            if (parseInt(order.status) === 4) {

                timelineBox.style.background = '#ffe5e5';

                // Ordered Date
                const orderedDate = statusTimes[0]
                    ? new Date(statusTimes[0]).toLocaleString()
                    : 'N/A';

                const li1 = document.createElement('li');

                li1.innerHTML =
                    `(Ordered Date) Pending: ${orderedDate}`;

                statusHistoryEl.appendChild(li1);


                // Cancelled Date
                const cancelledDate = statusTimes[4]
                    ? new Date(statusTimes[4]).toLocaleString()
                    : 'N/A';

                const li2 = document.createElement('li');

                li2.innerHTML = `
                    <strong style="color:#d32f2f;">
                        Cancelled:
                    </strong>

                    <span style="color:#d32f2f; font-weight:600;">
                        ${cancelledDate}
                    </span>
                `;

                statusHistoryEl.appendChild(li2);


            } else {

                timelineBox.style.background = '#f9f9f9';

                for (const [key, val] of Object.entries(statusTimes)) {

                    // Skip cancelled status
                    if (parseInt(key) === 4) {
                        continue;
                    }

                    const displayVal = val
                        ? new Date(val).toLocaleString()
                        : 'N/A';

                    const li = document.createElement('li');

                    if (parseInt(key) === 0) {

                        li.innerHTML =
                            `(Ordered Date) Pending: ${displayVal}`;

                    } else {

                        li.textContent =
                            `${statuses[key] || 'Unknown'}: ${displayVal}`;
                    }

                    statusHistoryEl.appendChild(li);
                }
            }


            // --------------------------------
            // Items Table
            // --------------------------------
            let html = '';
            let subtotal = 0;

            if (items.length > 0) {
                items.forEach(item => {
                    const price = parseFloat(item.price || 0);
                    const quantity =  parseInt(item.quantity || 0);
                    const itemSubtotal = quantity * price;
                    subtotal += itemSubtotal;
                    html += `
                        <tr>
                            <td>${item.item_name || 'N/A'}</td>
                            <td>${quantity}</td>
                            <td> ¥ ${price.toFixed(2)} </td>
                            <td> ¥ ${itemSubtotal.toFixed(2)} </td>
                        </tr>
                    `;
                });

            } else {

                html += `
                    <tr>
                        <td colspan="4"
                            style="text-align:center; padding:15px;">
                            No items found.
                        </td>
                    </tr>
                `;
            }

            // Subtotal
            html += `
                <tr class="total-row">
                    <td colspan="3"> Subtotal:</td>
                    <td> ¥ ${subtotal.toFixed(2)} </td>
                </tr>
            `;

            // Discount
            html += `
                <tr class="total-row1">
                    <td colspan="3"> Discount:</td>
                    <td>  - ¥ ${discount.toFixed(2)} </td>
                </tr>
            `;

            // Tax
            html += `
                <tr class="total-row1">
                    <td colspan="3">Tax (8%):   </td>
                    <td>  ¥ ${tax.toFixed(2)}  </td>
                </tr>
            `;

            // Delivery Charges
            html += `
                <tr class="total-row1">
                    <td colspan="3"> Delivery Charges: </td>
                    <td> ¥ ${cod.toFixed(2)}</td>
                </tr>
            `;

            // Box Charges
            html += `
                <tr class="total-row1">
                    <td colspan="3"> Box Charges:</td>
                    <td>¥ ${boxAmount.toFixed(2)}</td>
                </tr>
            `;

            // Total Payable
            html += `
                <tr class="total-row">
                    <td colspan="3"> <strong>Total Payable:</strong> </td>
                    <td><strong>  ¥ ${totalPayable.toFixed(2)} </strong> </td>
                </tr>
            `;

            document.getElementById('itemsContent').innerHTML = html;
            document.getElementById('itemsModal').style.display = 'flex';
        })

        .catch(err => {
            console.error('View Items Error:', err);
            alert(
                'Failed to fetch order items. Please check the browser console.'
            );
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

    function generateBillItems(order) {
        const items = order.items || [];
        let subtotal = 0;
        let html = `
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price (Rs)</th>
                        <th>Subtotal (Rs)</th>
                    </tr>
                </thead>
                <tbody>
        `;
        items.forEach(item => {

            const price = parseFloat(item.price || 0);
            const quantity = parseInt(item.quantity || 0);
            const itemSubtotal = quantity * price;

            subtotal += itemSubtotal;

            html += `
                <tr>
                    <td>${item.item_name || 'N/A'}</td>
                    <td>${quantity}</td>
                    <td>¥ ${price.toFixed(2)}</td>
                    <td>¥ ${itemSubtotal.toFixed(2)}</td>
                </tr>
            `;
        });

        if (items.length === 0) {
            html += `
                <tr>
                    <td colspan="4" style="text-align:center;">
                        No items found.
                    </td>
                </tr>
            `;
        }

        const discount = parseFloat(order.discount || 0);
        const tax = parseFloat(order.tax || 0);
        const cod = parseFloat(order.cod_amount || 0);
        const boxAmount = parseFloat(order.box_amount || 0);
        const totalPayable = parseFloat(order.total_amount || 0);

        html += `
            <tr class="total-row">
                <td colspan="3">Subtotal:</td>
                <td>¥ ${subtotal.toFixed(2)}</td>
            </tr>

            <tr class="total-row1">
                <td colspan="3">Discount:</td>
                <td>- ¥ ${discount.toFixed(2)}</td>
            </tr>

            <tr class="total-row1">
                <td colspan="3">Tax:</td>
                <td>¥ ${tax.toFixed(2)}</td>
            </tr>

            <tr class="total-row1">
                <td colspan="3">Delivery Charges:</td>
                <td>¥ ${cod.toFixed(2)}</td>
            </tr>

            <tr class="total-row1">
                <td colspan="3">Box Charges:</td>
                <td>¥ ${boxAmount.toFixed(2)}</td>
            </tr>

            <tr class="total-row">
                <td colspan="3">
                    <strong>Total Payable:</strong>
                </td>
                <td>
                    <strong>¥ ${totalPayable.toFixed(2)}</strong>
                </td>
            </tr>
        `;

        html += `
                </tbody>
            </table>
        `;

        return html;
    }

    document.getElementById('cancelForm').addEventListener('submit', function(){
        this.querySelector('button[type="submit"]').disabled = true;
    });

    function printBill() {

        if (!window.currentOrderId) {
            alert('Order ID is not available.');
            return;
        }

        const url =
            "{{ url('/orders') }}/"
            + window.currentOrderId
            + "/print";

        console.log("Opening bill:", url);

        window.open(
            url,
            '_blank',
            'width=500,height=800'
        );
    }
</script>

</body>
</html>