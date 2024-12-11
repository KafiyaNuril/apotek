@extends('layouts.layout')
@section('content')
    <div class="d-flex justify-content-between mt-3">
        <form action="" role="search" method="GET" class="d-flex mb-2">
            <input type="date" name="search" placeholder="Search Data" aria-label="Search" class="form-control me-2">
            <button class="btn btn-outline-success" type="submit">Search</button>
            <a href="{{ route('pembelian.admin') }}" class="btn btn-outline-success mx-2">Clear</a>
        </form>
        <a href="{{ route('pembelian.admin.export') }}" class="btn btn-success me-2 mb-2">Export Excel</a>
    </div>
    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <th>No</th>
            <th>Nama Pembeli</th>
            <th>Obat</th>
            <th>Total Harga</th>
            <th>Nama Kasir</th>
            <th>Tanggal Pembelian</th>
        </thead>
        <tbody>
            @foreach ($orders as $index => $order)
                <tr>
                    <td> {{ ($orders->currentpage() - 1) * $orders->perPage() + ($index + 1) }} </td>
                    <td>{{ $order['name_customer'] }}</td>
                    <td>
                        <ol>
                            @foreach ($order->medicines as $medicine)
                                <li>{{ $medicine['name_medicine'] }} ({{ $medicine['qty'] }}) : Rp.
                                    {{ number_format($medicine['total_price'], 0, '.', '.') }}</li>
                            @endforeach
                        </ol>
                    </td>
                    <td>Rp {{ number_format($order['total_price'], 0, ',', '.') }}</td>
                    <td>{{ $order['user']['name'] }}</td>
                    {{-- carbon : package untuk memanipulasi tanggal, d (tgl), f (nama bulan), Y (tahun lengkap) --}}
                    <td>{{ \Carbon\Carbon::create($order->created_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm:ss') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end">{{ $orders->links() }}</div>
@endsection
