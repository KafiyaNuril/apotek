<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

// konsep implements dari oop php interface
class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // menentukan data apa saja yang akan dimunculkan di excel
    // 'user' didapat dari relasi one to many model Order
    public function collection()
    {
        // return Order::all();
        return Order::with('user')->orderBy('created_at', 'asc')->get();
    }

    // membuat th (table head)
    public function headings(): array
    {
        return [
            "ID",
            "Nama Kasir",
            "Daftar Obat",
            "Nama Pembeli",
            "Total Harga",
            "Tanggal"
        ];
    }

    public function map($order): array
    {
        // 1. Antangin ( 2pcs ) Rp. 5.000, 2. ......
        // string menampung data2 obat
        $daftarObat = "";
        foreach ($order->medicines as $key => $value) {
            $obat = $key+1 . ". " . $value['name_medicine'] . " ( " . $value['qty'] . " pcs ) Rp. " . number_format($value['total_price'], 0, ',', '.') . " , ";
            // menggabungkan nilai di $daftaObat dengan string $obat
            $daftarObat .= $obat;
        }
        return [
            $order->id,
            $order->user->name,
            $daftarObat,
            $order->name_customer,
            "Rp. " . number_format($order->total_price, 0, ',', '.'),
            \Carbon\Carbon::create($order->created_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm:ss')
        ];
    }
}
