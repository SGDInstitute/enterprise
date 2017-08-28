<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $order->invoice->id }}</title>
    <style>
        body {
            font-family: verdana, sans-serif;
        }

        table {
            width: 100%;
            margin-bottom: 2em;
        }

        th, td {
            padding: 3pt;
        }

        th {
            text-align: left;
        }

        table.collapsed {
            border-collapse: collapse;
            border: 1pt solid black;
        }

        table.collapsed td, table.collapsed th {
            border: 1pt solid black;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #777;
        }

        .fifty {
            width: 50%;
        }

        .sixty {
            width: 60%;
        }

        .forty {
            width: 40%;
        }
    </style>
</head>
<body>
<div class="container">
    <table>
        <tr>
            <td class="sixty">
                <img src="{{ asset('img/logo.png') }}" alt="Midwest Institute for Sexuality and Gender Diversity logo" width="250px"><br><br>
                {{ config($order->event->stripe . ".address") }}<br>
                <a href="mailto:finance@sgdinstitute.org">finance@sgdinstitute.org</a>
            </td>
            <td class="forty">
                <h1 class="text-right">Invoice</h1>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="sixty">
                {{ $order->invoice->address }} {{ $order->invoice->address_2 }}<br>
                {{ $order->invoice->city }}, {{ $order->invoice->state }} {{ $order->invoice->zip }}
            </td>
            <td class="forty text-right">
                <strong>Invoice:</strong> #{{ str_pad($order->invoice->id, 6, "0", STR_PAD_LEFT) }}<br>
                <strong>Created Date:</strong> {{ $order->invoice->created_at->toFormattedDateString() }}<br>
                <strong>Due Date:</strong> {{ $order->invoice->created_at->addDays(60)->toFormattedDateString() }}
            </td>
        </tr>
    </table>
    <table class="collapsed">
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        @foreach($order->getTicketsWithNameAndAmount() as $ticket)
            <tr>
                <td>{{ $ticket['name'] }} for {{ $order->event->title }}</td>
                <td>{{ $ticket['count'] }}</td>
                <td>${{ number_format($ticket['cost']/100, 2) }}</td>
                <td>${{ number_format($ticket['amount']/100, 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
            <td>${{ number_format($order->amount/100, 2) }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td>
                <p>For any concerns or questions regarding payment, the invoice, or for a W-9, please contact <a
                            href="mailto:finance@sgdinstitute.org">finance@sgdinstitute.org</a>.
                    Include your issue or concern, invoice and order numbers, and best method of contact.</p>
                <p>Please mail payment to: {{ config($order->event->stripe . ".address") }}</p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>