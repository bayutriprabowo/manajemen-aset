<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="title">
        {{ $title }}
    </div>
    <p>Report Period: {{ $startDate }} to {{ $endDate }}</p>
    <p>Item: {{ $itemName }}, Departemen: {{ $departmentName }}</p>
    <h3>Transactions:</h3>
    <table>
        <thead>
            <tr>
                <th>Transaction Date</th>
                <th>Item Name</th>
                <th>Kode</th>
                <th>In</th>
                <th>Out</th>
                <th>Saldo Akhir</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td>{{ $itemName }}</td>
                <td>{{ 'saldo awal' }}</td>
                <td></td>
                <td></td>
                <td>{{ $closingBalance }}</td>
            </tr>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_date }}</td>
                    <td>{{ $transaction->masterItem->name }}</td>
                    <td>{{ $transaction->code }}</td>
                    <td>{{ $transaction->in }}</td>
                    <td>{{ $transaction->out }}</td>
                    <?php $closingBalance += $transaction->in;
                    $closingBalance -= $transaction->out; ?>
                    <td>{{ $closingBalance }}</td>

                </tr>
            @endforeach

        </tbody>
    </table>
</body>

</html>
