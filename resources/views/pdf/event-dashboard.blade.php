<!doctype html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
        <h2>General Stats</h2>
        <dl>
            <dt style="font-weight: bold">Days until Event</dt>
            <dd style="margin-left: 0">{{ $daysLeft }}</dd>

            <dt style="font-weight: bold; margin-top: 10px;">Reservations</dt>
            <dd style="margin-left: 0">{{ $reservations }}</dd>

            <dt style="font-weight: bold; margin-top: 10px;">Orders</dt>
            <dd style="margin-left: 0">{{ $orders }}</dd>

            <dt style="font-weight: bold; margin-top: 10px;">Potential Money from Reservations</dt>
            <dd style="margin-left: 0">{{ $potentialMoney }}</dd>

            <dt style="font-weight: bold; margin-top: 10px;">Money Made from Orders</dt>
            <dd style="margin-left: 0">{{ $moneyMade }}</dd>
        </dl>

        <h2>Paid Tickets Breakdown</h2>
        <x-galaxy.paid-breakdown :data="$tablePaid" />

        <h2>Filled Tickets Breakdown</h2>
        <x-galaxy.filled-breakdown :data="$tableFilled" long />
    </div>
</body>

</html>
