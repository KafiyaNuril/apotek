<?php

namespace App\Http\Controllers;

use App\Exports\MedicineExport;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Maatwebsite\Excel\Facades\Excel;

class MedicineController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new MedicineExport, 'rekap-obat.xlsx');
        // new order = menentukan file apa yang akan di download
    }

    /**
     * R: Read, menampilkan banyak data/halaman awal fitur
     */
    public function index(Request $request)
    {
        //all()mengambil semua data
        // orderBy() : mengurutkan
        // ASC : A-Z, 0-9
        // DEC : z-a, 9-0
        // kalau ambil semua data tp ada proses filter sebelumnya, all nya ganti jadi get
        // simplePaginate() : memisahkan data dengan pagination, angka 5 menunjukan data per halaman
        $orderStock = $request->sort_stock ? 'stock' : 'name';
        $medicines = Medicine::where('name', 'LIKE' , '%'.$request->search_obat. '%')->orderBy($orderStock, 'ASC')->simplePaginate(5)->appends($request->all());        // compact(); mengirim data ke view blade (isinya sama dengan $)
        return view('medicine.index', compact('medicines'));
    }

    /**
     * C: Create, menampilkan form untuk menambahkan data
     */
    public function create()
    {
        //
        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     * C: Create, menambahkan data ke db/eksekusi formulir / memproses
     */
    public function store(Request $request) //mengambil data isian dari inputan / menyimpan data dari inputan
    {
        $request->validate([
            // tanda petik dari migrations
            'name' => 'required|max:100',
            'type' => 'required|min:3',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ], [
            'name.required' => 'Nama obat harus diisi!',
            'type.required' => 'Tipe obat harus diisi!',
            'price.required' => 'Harga obat harus diisi!',
            'stock.required' => 'Stok obat harus diisi!',
            'name.max' => 'Nama obat maksimal 100 karakter!',
            'type.min' => 'Tipe obat minimal 3 karakter!',
            'price.numeric' => 'Harga obat harus berupa angka!',
            'stock.numeric' => 'Stok obat harus berupa angka!',
        ]);

        // method-method dalam models pada laravel == ORM / eloquent
        // memanggil sql
        Medicine::create([
            'name' => $request->name, //name pada request dari name post namanya
            'type' => $request->type,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil Menambah Data Obat!');
    }

    /**
     * R: Read, menampilkan data spesifik (data cuman 1)
     */
    public function show(string $id)
    {
        //
    }

    /**
     * U: Update, menampilkan form untuk mengedit data
     * parameter diambil dari route
     */
    public function edit(string $id)
    {
        //function where() : mengambil data spesifik
        // first() : mengambil data pertama
        $medicine = Medicine::where('id', $id)->first();
        return view('medicine.edit', compact('medicine'));
    }

    /**
     * U: Update, mengupdate data ke db / ekseskusi formulir edit
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
        ]);

        Medicine::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
        ]);

        return redirect()->route('obat.data')->with('success', 'Berhasil Mengupdate Data Obat');
    }

    public function updateStock(Request $request, $id)
    {
        // untuk modal tanpa ajax, tdk support validasi, jdi gunakan isset untuk pengecekan requirednya
        if (isset($request->stock) == false) {
            $dataSebelumnya = Medicine::where('id', $id)->first();
            // kembali dengan pesan, id sebelumnya, dan stock sebelumnya (stock awal)
            return redirect()->back()->with([
                'failed' => 'Stock Tidak Boleh Kosong!',
                'id' => $id,
                'stock' => $dataSebelumnya->stock
            ]);
        }
        // jka tdk kosong, langsung update stock
        Medicine::where('id', $id)->update([
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil Mengupdate Stock Obat');
    }

    /**
     * D: Delete, menghapus data dari db
     */
    public function destroy(string $id)
    {
        //
        $deleteData = Medicine::where('id', $id)->delete();

        if ($deleteData) {
            return redirect()->back()->with('success', 'Berhasil Menghapus Data Obat');
        } else {
            return redirect()->back()->with('failed', 'Gagal Menghapus Data Obat');
        }
    }
}
