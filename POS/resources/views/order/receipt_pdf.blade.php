<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        h1, h2 {
            color: #2c3e50;
            margin-bottom: 8px;
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 18px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-top: 20px;
        }

        p {
            margin: 4px 0;
        }

        .section {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #aaa;
        }

        th, td {
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .notes {
            font-style: italic;
            color: #555;
        }

        table, tr, td, th {
            page-break-inside: avoid;
        }

        .logo {
            display: block;
            margin: 0 auto 10px;
            max-height: 80px;
        }
    </style>
</head>

<body>
<div class="container">

    <!-- Logo (for PDF must use public_path) -->
    <!-- <img src="{{ public_path('images/logo.png') }}" class="logo"> -->

    <h1>Order Receipt</h1>

    <p style="text-align:center;">
        <strong>Order ID:</strong> {{ $order->order_code }} |
        <strong>Date:</strong> {{ $order->added_date->format('d M Y, H:i') }}
    </p>

    <!-- Restaurant Info -->
    <div class="section">
        <h2>Restaurant Info</h2>
        <p><strong>Name:</strong> Rajarata Sakura Restaurant</p>
        <p><strong>Phone:</strong> +81 80-1756-2569 / 0296 48 6606</p>
        <p><strong>Address:</strong> 110-65, FUNYU, CHIKUSEI SHI, IBARAKI KEN, JAPAN</p>
    </div>

    <!-- Customer Details -->
    <div class="section">
        <h2>Customer Details</h2>

        @if($order->customer)
            <p><strong>Name:</strong> 
                {{ $order->customer->customer_first_name }} 
                {{ $order->customer->customer_last_name }}
            </p>

            <p><strong>Email:</strong> {{ $order->customer->customer_email }}</p>

            <p><strong>Phone:</strong> {{ $order->customer->customer_phone }}</p>

            <p><strong>Address:</strong>
                {{ $order->customer->street_name }}
                @if($order->customer->apartment_no)
                    , {{ $order->customer->apartment_no }}
                @endif,
                {{ $order->customer->city }},
                {{ $order->customer->perfecture }},
                {{ $order->customer->postal_code }}
            </p>
        @else
            <p>No customer data found</p>
        @endif

    </div>

    <!-- Delivery Details -->
    <div class="section">
        <h2>Delivery Details</h2>

        @if($order->customer)
            <p><strong>Name:</strong> 
                {{ $order->customer->receiver_first_name }} 
                {{ $order->customer->receiver_last_name }}
            </p>

            <p><strong>Email:</strong> {{ $order->customer->receiver_email }}</p>

            <p><strong>Phone:</strong> {{ $order->customer->receiver_phone }}</p>

            <p><strong>Address:</strong>
                {{ $order->customer->receiver_street_name }}
                @if($order->customer->receiver_apartment_no)
                    , {{ $order->customer->receiver_apartment_no }}
                @endif,
                {{ $order->customer->receiver_city }},
                {{ $order->customer->receiver_prefecture }},
                {{ $order->customer->receiver_postal_code }}
            </p>
        @else
            <p>No delivery data found</p>
        @endif

    </div>

    <!-- Payment -->
    <div class="section">
        <h2>Payment Details</h2>
        <p><strong>Payment method:</strong> Cash On Delivery</p>
    </div>

    <!-- Items -->
    <div class="section">
        <h2>Order Items</h2>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->item->item_name ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>¥ {{ number_format($item->price, 2) }}</td>
                    <td>¥ {{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach

                <tr class="total-row">
                    <td colspan="3" style="text-align:right;">Total Amount</td>
                    <td>¥ {{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Notes -->
    @if($order->notes)
    <div class="section notes">
        <h2>Notes</h2>
        <p>{{ $order->notes }}</p>
    </div>
    @endif

</div>
</body>
</html>