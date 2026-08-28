<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>
        Bill - {{ $order->order_code }}
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, Helvetica, sans-serif;
            background: #ffffff;
            color: #000;
        }

        .bill {
            width: 80mm;
            margin: auto;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 3px 0;
            font-size: 11px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .order-info {
            font-size: 11px;
            line-height: 1.6;
        }

        .customer-info {
            font-size: 11px;
            line-height: 1.6;
        }

        .customer-title {
            font-weight: bold;
            margin-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 11px;
        }

        th {
            border-bottom: 1px dashed #000;
            padding: 5px 2px;
            text-align: left;
        }

        td {
            padding: 5px 2px;
            vertical-align: top;
        }

        .qty {
            text-align: center;
            width: 35px;
        }

        .price {
            text-align: right;
        }

        .summary td {
            padding: 3px 2px;
        }

        .summary .label {
            text-align: right;
        }

        .total {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            font-weight: bold;
            font-size: 13px;
            padding: 6px 2px !important;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 11px;
        }

        .print-button {
            display: block;
            margin: 20px auto;
            padding: 8px 20px;
            border: none;
            background: #4b0f3a;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        @media print {

            body {
                padding: 0;
            }

            .bill {
                width: 80mm;
            }

            .print-button {
                display: none;
            }

            @page {
                size: 80mm auto;
                margin: 0;
            }
        }

    </style>

</head>

<body>

<div class="bill">

    <!-- HEADER -->

    <div class="header">

        <h2>RESTAURANT</h2>

        <p>INVOICE / BILL</p>

    </div>

    <div class="divider"></div>


    <!-- ORDER INFORMATION -->

    <div class="order-info">

        <div>
            <strong>Order:</strong>
            {{ $order->order_code }}
        </div>

        <div>
            <strong>Date:</strong>
            {{ \Carbon\Carbon::parse($order->added_date)->format('Y-m-d H:i') }}
        </div>

    </div>


    <div class="divider"></div>


    <!-- CUSTOMER -->

    @if($order->customer)

        <div class="customer-info">

            <div class="customer-title">
                Customer Details
            </div>

            <div>
                <strong>Name:</strong>
                {{ $order->customer->customer_first_name }}
                {{ $order->customer->customer_last_name }}
            </div>

            <div>
                <strong>Phone:</strong>
                {{ $order->customer->customer_phone }}
            </div>

        </div>

        <div class="divider"></div>

    @endif


    <!-- ITEMS -->

    <table>

        <thead>

            <tr>

                <th>
                    Item
                </th>

                <th class="qty">
                    Qty
                </th>

                <th class="price">
                    Amount
                </th>

            </tr>

        </thead>

        <tbody>

        @php
            $subtotal = 0;
        @endphp

        @foreach($order->items as $orderItem)

            @php

                $price = (float) $orderItem->price;

                $quantity = (int) $orderItem->quantity;

                $itemSubtotal = $price * $quantity;

                $subtotal += $itemSubtotal;

            @endphp

            <tr>

                <td>
                    {{ $orderItem->item->item_name ?? 'N/A' }}
                </td>

                <td class="qty">
                    {{ $quantity }}
                </td>

                <td class="price">
                    ¥ {{ number_format($itemSubtotal, 2) }}
                </td>

            </tr>

        @endforeach

        </tbody>

    </table>


    <div class="divider"></div>


    <!-- SUMMARY -->

    <table class="summary">

        <tr>

            <td class="label">
                Subtotal:
            </td>

            <td class="price">
                ¥ {{ number_format($subtotal, 2) }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Discount:
            </td>

            <td class="price">
                - ¥ {{ number_format($order->discount ?? 0, 2) }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Tax:
            </td>

            <td class="price">
                ¥ {{ number_format($order->tax ?? 0, 2) }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Delivery Charges:
            </td>

            <td class="price">
                ¥ {{ number_format($order->cod_amount ?? 0, 2) }}
            </td>

        </tr>


        <tr>

            <td class="label total">
                TOTAL:
            </td>

            <td class="price total">
                ¥ {{ number_format($order->total_amount ?? 0, 2) }}
            </td>

        </tr>

    </table>


    <!-- FOOTER -->

    <div class="footer">

        <strong>Thank you for your order!</strong>

        <br>

        Please visit us again.

    </div>

</div>


<button
    class="print-button"
    onclick="window.print()">

    Print Bill

</button>


<script>

    window.onload = function () {

        window.print();

    };

</script>

</body>

</html>