<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Order Receipt</title>

<style>
body{
    font-family:Arial, sans-serif;
    font-size:14px;
    color:#333;
}
.container{
    padding:20px;
}
h1{
    text-align:center;
}
h2{
    font-size:18px;
    border-bottom:1px solid #ddd;
    padding-bottom:5px;
}
.section{
    border:1px solid #ddd;
    padding:10px;
    margin-bottom:15px;
}
table{
    width:100%;
    border-collapse:collapse;
}
table,th,td{
    border:1px solid #aaa;
}
th,td{
    padding:8px;
}
th{
    background:#f5f5f5;
}
.total-row td{
    font-weight:bold;
    background:#eee;
}
</style>

</head>
<body>

<div class="container">

<h1>Order Receipt</h1>

<p style="text-align:center;">
<strong>Order ID:</strong> {{ $order->order_code }} |
<strong>Date:</strong> {{ $order->added_date->format('d M Y, H:i') }}
</p>

<div class="section">
<h2>Restaurant Info</h2>
<p><strong>Name:</strong> Rajarata Sakura Restaurant</p>
<p><strong>Phone:</strong> +81 80-1756-2569 / 0296 48 6606</p>
<p><strong>Address:</strong> 110-65, FUNYU, CHIKUSEI SHI, IBARAKI KEN, JAPAN</p>
</div>

<div class="section">
<h2>Customer Details</h2>
<p><strong>Name:</strong>
{{ $order->customer->customer_first_name }}
{{ $order->customer->customer_last_name }}
</p>

<p><strong>Email:</strong> {{ $order->customer->customer_email }}</p>
<p><strong>Phone:</strong> {{ $order->customer->customer_phone }}</p>
</div>

<div class="section">
<h2>Delivery Details</h2>
<p><strong>Name:</strong>
{{ $order->customer->receiver_first_name }}
{{ $order->customer->receiver_last_name }}
</p>

<p><strong>Email:</strong> {{ $order->customer->receiver_email }}</p>
<p><strong>Phone:</strong> {{ $order->customer->receiver_phone }}</p>
</div>

<div class="section">
<h2>Payment Details</h2>

<p><strong>Subtotal:</strong>
¥ {{ number_format($order->total_amount - $order->tax - $order->cod_amount,2) }}
</p>

<p><strong>Tax:</strong>
¥ {{ number_format($order->tax,2) }}
</p>

<p><strong>COD:</strong>
¥ {{ number_format($order->cod_amount,2) }}
</p>

</div>

<div class="section">
<h2>Items</h2>

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
<td>¥ {{ number_format($item->price,2) }}</td>
<td>¥ {{ number_format($item->subtotal,2) }}</td>
</tr>
@endforeach

<tr>
<td colspan="3" align="right">Tax</td>
<td>¥ {{ number_format($order->tax,2) }}</td>
</tr>

<tr>
<td colspan="3" align="right">COD</td>
<td>¥ {{ number_format($order->cod_amount,2) }}</td>
</tr>

<tr class="total-row">
<td colspan="3" align="right">Total</td>
<td>
¥ {{ number_format($order->total_amount,2) }}
</td>
</tr>

</tbody>
</table>
</div>

@if($order->notes)
<div class="section">
<h2>Notes</h2>
<p>{{ $order->notes }}</p>
</div>
@endif

</div>

</body>
</html>