@extends('layouts.layout')
@section('content')
    <h2>Data Pembelian : {{Auth::user()->name}}</h2>
    <div class="d-flex justify-content-between mt-3">
        <form action="{{ route('pembelian.order') }}" role="search" method="GET" class="d-flex mb-2">
            <input type="date" name="search" placeholder="Search Data" aria-label="Search" class="form-control me-2">
            <button class="btn btn-outline-success" type="submit">Search</button>
            <a href="{{ route('pembelian.order') }}" class="btn btn-outline-success mx-2">Clear</a>
        </form>
        <a href="{{ route('pembelian.formulir') }}" class="btn btn-primary mb-2">+ Tambah Pesanan</a>
    </div>
    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <th>No</th>
            <th>Nama Pembeli</th>
            <th>Obat</th>
            <th>Total Harga</th>
            <th>Nama Kasir</th>
            <th>Tanggal Pembelian</th>
            <th>Aksi</th>
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
                    <td>
                        <a href="{{ route('pembelian.download_pdf', $order['id'])}}" class="btn btn-warning"><i class="fa-solid fa-download"></i> Cetak Struk</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end">{{ $orders->links() }}</div>
@endsection
