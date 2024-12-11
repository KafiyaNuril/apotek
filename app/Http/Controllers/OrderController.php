<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;

class OrderController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new OrderExport, 'rekap-pembelian.xlsx');
        // new order = menentukan file apa yang akan di download
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::with('user')->where('created_at', 'LIKE', '%' . $request->search . '%')->simplePaginate(5);

        return view('order.kasir.kasir', compact('orders'));
    }

    public function indexAdmin(Request $request)
    {
        $orders = Order::with('user')->where('created_at', 'LIKE', '%' . $request->search . '%')->simplePaginate(5);

        return view('order.admin.data', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view('order.kasir.form', compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi data request
        $request->validate([
            "name_customer" => "required",
            "medicines" => "required",
        ]);

        // mencari value array yang datanya sama
        $arrayValue = array_count_values($request->medicines);
        // membuat array kosong untuk menampung nilai format array yang baru
        $arrayNewMedicines = [];
        // looping array data duplikat
        foreach ($arrayValue as $key => $value) {
            // mencari data obat berdasarkan id yang dipilih
            $medicine = Medicine::where('id', $key)->first();

            if($medicine['stock'] < $value) {
                $valueBefore = [
                    "name_customer" => $request->name_customer,
                    "medicines" => $request->medicines,
                ];
                $msg = 'Stok Obat '. $medicine['name'].' Tidak Cukup';
                return redirect()->back()->withInput()->with(['failed' => $msg, "valueBefore" => $valueBefore]);
            } else {
                $medicine['stock'] -= $value;
                $medicine->save();
            }

            // untuk mentotalkan harga medicine
            $totalPrice = $medicine['price'] * $value;
            // format array baru
            $arrayItem = [
                "id" => $key,
                "name_medicine" => $medicine['name'],
                "qty" => $value,
                "price" => $medicine['price'],
                "total_price" => $totalPrice
            ];
                    // menambahkan data ke array
            array_push($arrayNewMedicines, $arrayItem);
        }

        // untuk menghitung total
        $total = 0;
        // looping data array dari array format baru
        foreach ($arrayNewMedicines as $item) {
            // mentotal Price sebelum ppn dari medicine kedalam variabel total
            $total += $item['total_price'];
        }

        // merubah total dikali dengan ppn sebesar 100%
        $ppn = $total + ($total * 0.1);

        // tambahkan result kedalam database order
        $orders = Order::create([
            'user_id' => Auth::user()->id,
            'medicines' => $arrayNewMedicines,
            'name_customer' => $request->name_customer,
            'total_price' => $ppn,
        ]);

        if($orders) {
            // Jika tambah orders berhasil, ambil data order berdasarkan kasir yang sedang logim (where),
            // dengan tanggal paling baru (orderBy), ambil hanya satu data (First)
            $result = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
            return redirect()->route('pembelian.print', $result['id'])->with('success', 'Berhasil Order');
        } else {
            return redirect()->back()->with('failed', 'Gagal Order');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order, $id)
    {
        $order = Order::find($id);
        return view('order.kasir.print', compact('order'));
    }

    public function downloadPDF($id)
    {
        // tentukan data yang akan dimunculkan di pdf
        $order = Order::where('id', $id)->first()->toArray();
        // buat variabel yg akan digunakan di pdf
        view()->share('order', $order); //dipetik  sama dengan nama variabel yang ada di blade
        // panggil file blade yang akan diubah menjadi pdf
        $pdf = Pdf::loadview('order.kasir.pdf', $order);
        // proses download & nama filenya
        return $pdf->download('Struk Pembayaran Obat.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
