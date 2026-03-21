<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>

    <!-- Inline CSS for PDF -->
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Receipt</h1>

        <!-- Restaurant Info -->
        <div class="section">
            <h2>Restaurant Info</h2>
            <p><strong>Name:</strong> Rajarata Sakura Restaurant</p>
            <p><strong>Phone:</strong> +94 123 456 789</p>
            <p><strong>Address:</strong> 123 Main Street, Colombo</p>
        </div>

        <!-- Customer Details -->
        <div class="section">
            <h2>Customer Details</h2>
            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
            <p><strong>Address:</strong> {{ $order->customer_address }}</p>
        </div>

        <!-- Delivery Details -->
        <div class="section">
            <h2>Delivery Details</h2>
            <p><strong>Name:</strong> {{ $order->receiver_name }}</p>
            <p><strong>Email:</strong> {{ $order->receiver_email }}</p>
            <p><strong>Phone:</strong> {{ $order->receiver_phone }}</p>
            <p><strong>Address:</strong> {{ $order->receiver_address }}</p>
        </div>

        <!-- Order Items -->
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
                        <td>{{ $item->item->name ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td>{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3" style="text-align:right;">Total Amount</td>
                        <td>{{ number_format($order->total_amount, 2) }}</td>
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