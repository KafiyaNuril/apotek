<?php

namespace App\Exports;

use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MedicineExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Medicine::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Obat',
            'Jenis Obat',
            'Harga',
            'Stok',
            'Tanggal'
        ];
    }

    public function map($medicine): array
    {
        return [
            $medicine->id,
            $medicine->name,
            $medicine->type,
            "Rp. " . number_format($medicine->price, 0, ',', '.'),
            $medicine->stock,
            \Carbon\Carbon::create($medicine->created_at)->locale('id')->isoFormat('dddd, DD MMMM YYYY HH:mm:ss'),
        ];
    }
}
