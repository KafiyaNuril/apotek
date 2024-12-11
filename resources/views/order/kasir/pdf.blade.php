<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk Pembelian</title>
    <style>
        @media print {
            .print-btn {
                display: none;
            }

            nav {
                display: none;
            }
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px;
            background-color: white;
            width: 70%;
        }

        .header {
            text-align: start;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .print-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .print-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="header">
                <div class="info">
                    <h1>Apotek App</h1>
                    <p><strong>Nama Pembeli :</strong> {{ $order['name_customer'] }}</p>
                    <p><strong>Nama Kasir :</strong> {{ Auth::user()['name'] }}</p>
                    <p><strong>Tanggal Pembelian:</strong> {{ \Carbon\Carbon::create($order['created_at'])->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm:ss') }}</p>
                </div>
            </div>
            <table class="table">
                <tr>
                    <th>Obat</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
                @foreach ($order['medicines'] as $medicine)
                    @if (is_array($medicine))
                        <tr>
                            <td>{{ $medicine['name_medicine'] }}</td>
                            <td>{{ $medicine['qty'] }}</td>
                            <td>Rp {{ number_format($medicine['price'], 0, ',', '.') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $medicine['name'] }}</td>
                            <td>{{ $medicine['quantity'] }}</td>
                            <td>Rp {{ number_format($medicine['price'], 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="2" class="total">PPN (10%)</td>
                    @php
                        $ppn = $order['total_price'] * 0.1;
                    @endphp
                    <td>Rp {{ number_format($ppn, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="total">Total Harga</td>
                    <td>Rp {{ number_format($order['total_price'], 0, ',', '.') }}</td>
                </tr>
            </table>
            <b><p class="text-center">Terima kasih atas pembelian Anda!</p></b>
            <div class="identitas">
                <p>Alamat: Belift Lab, Korea Selatan</p>
                <p>Email: apotekapp@gmail.com</p>
                <p>Phone: +62 81585819152</p>
            </div>
        </div>
    </div>
</body>
</html>
