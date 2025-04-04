<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receiving Detail</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
        }

        .header {
            text-align: left;
            margin-bottom: 20px;
        }

        .header img {
            width: 150px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 2px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .remark {
            margin-top: 20px;
        }

        .signature-section {
            width: 100%;
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
        }

        .signature-line {
            display: block;
            margin-top: 40px;
            width: 100%;
            border-bottom: 1px solid black;
        }

        .signature-text {
            margin-top: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Logo & Header -->
    <div class="header">
        <img src="{{ $image }}" alt="Company Logo">
    </div>

    <!-- Receiving Information -->
    <div class="info">
        <p><strong>No. #{{ $receivingID }}</strong></p>
        <p><strong>Date:</strong> {{ $date }}</p>
        <p><strong>Create By:</strong> {{ $create_by }}</p>
    </div>

    <h2 style="text-align: center;">RECEIVING</h2>

    <!-- Table -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Request Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $inventory }}</td>
                <td>{{ $quantity }}</td>
                <td>{{ $price }}</td>
                <td>{{ $price_qty }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Remark -->
    <div class="remark">
        <p><strong>Remark:</strong></p>
        <p>{{ $remark }}</p>
    </div>

    <!-- Signature Section using Table -->
    <table style="width: 100%; margin-top: 50px; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; text-align: left; padding-top: 40px;">
                <p class="signature-text">TTD Penerima</p>
            </td>
            <td style="width: 50%; text-align: right; padding-top: 40px;">
                <p class="signature-text">{{ $create_by }}</p>
            </td>
        </tr>
    </table>


</body>

</html>
