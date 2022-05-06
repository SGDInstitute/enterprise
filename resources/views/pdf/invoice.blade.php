<!doctype html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Order {{ $order->formattedId }}</title>
    <style>
        body {
            font-family: verdana, sans-serif;
        }

        table {
            width: 100%;
            margin-bottom: 2em;
        }

        th,
        td {
            padding: 3pt;
        }

        th {
            text-align: left;
        }

        table.collapsed {
            border-collapse: collapse;
            border: 1pt solid black;
        }

        table.collapsed td,
        table.collapsed th {
            border: 1pt solid black;
        }

        .text-right {
            text-align: right;
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
                    <img src="{{ asset('img/institute-logo_horiz-color.png') }}" alt="Midwest Institute for Sexuality and Gender Diversity logo" width="50%" />
                    <br/><br/>
                    {{ config('globals.institute_address') }}<br/>
                    <a href="mailto:finance@sgdinstitute.org">finance@sgdinstitute.org</a>
                </td>
                <td class="forty">
                    @if ($order->isPaid())
                    <h1 class="text-right">Receipt</h1>
                    @else
                    <h1 class="text-right">Invoice</h1>
                    @endif
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="sixty">
                    @if ($order->invoice->name && $order->invoice->email)
                    {{ $order->invoice->name }}<br/>
                    {{ $order->invoice->email }}<br/>
                    {{ $order->formattedAddress }}
                    @else
                    {!! nl2br($order->invoice['billable']) !!}
                    @endif
                </td>
                <td class="text-right forty">
                    <strong>Order:</strong> {{ $order->formattedId }}<br>
                    <strong>Created Date:</strong> {{ $order->invoice['created_at'] }}<br>
                    @if ($order->isPaid())
                    <strong>Paid Date:</strong> {{ $order->paid_at->format('m/d/Y') }}
                    @else
                    <strong>Due Date:</strong> {{ $order->invoice['due_date'] }}
                    @endif
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
            @foreach ($order->ticketsFormattedForInvoice() as $ticket)
            <tr>
                <td>{{ $ticket['item'] }}</td>
                <td>{{ $ticket['quantity'] }}</td>
                <td>{{ $ticket['price'] }}</td>
                <td>{{ $ticket['total'] }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                <td>{{ $order->subtotal }}</td>
            </tr>
        </table>
        @if ($order->isPaid())
        <table>
            <tr>
                <td>
                    @if ($transaction['type'] === 'check')
                        <p>Paid with check {{ $transaction['check_number'] }} for {{ $order->formattedAmount }}</p>
                    @elseif ($transaction['type'] === 'card')
                        <p>Paid with a {{ $transaction['brand'] }} that expires on {{ $transaction['exp'] }} ending with {{ $transaction['last4'] }}</p>
                    @endif
                </td>
            </tr>
            @if ($order->event->refund_policy)
            <tr>
                <td>
                    {!! $order->event->refund_policy !!}
                </td>
            </tr>
            @endif
        </table>
        @else
        <table>
            <tr>
                <td>
                    <p>Payment must be postmarked by <strong>{{ $order->invoice['due_date'] }}</strong>. For any concerns or questions regarding payment or the invoice please contact <a href="mailto:finance@sgdinstitute.org">finance@sgdinstitute.org</a>.
                        Include your issue or concern, invoice and order numbers, and best method of contact.</p>
                    <p>Please make check payable to “Midwest Institute for Sexuality and Gender Diversity” and mail payment to: {{ config('globals.institute_address') }}</p>
                </td>
            </tr>
            @if ($order->event->refund_policy)
            <tr>
                <td>
                    {!! $order->event->refund_policy !!}
                </td>
            </tr>
            @endif
        </table>
        @endif
    </div>
</body>

</html>
