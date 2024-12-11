@extends('layouts.layout')

@section('content')
<h1 class="text-center mt-4">Halaman Edit Obat</h1>
{{--fungsi koma di route untuk memisahkan namenya sama path dinamisnya--}}
{{--$medicine diambil dari MedicineController funtion edit--}}
    <form action="{{ route('obat.edit.formulir', $medicine['id']) }}" method="POST" class="card-p-5x">
        @csrf
        @method('PATCH') {{--untuk menimpa method html, di ambil dari route http method
        put digunakan untuk mengubah semua data
        patch untuk menupdate sebagian--}}
        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success')}}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama Obat : </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $medicine['name'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="type" class="col-sm-2 col-form-label">Jenis Obat :</label>
            <div class="col-sm-10">
                <select class="form-select" id="type" name="type">
                    <option selected disabled hidden> Pilih</option>
                    <option value="tablet" {{$medicine ['type'] == 'tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="sirup" {{$medicine ['type'] == 'sirup' ? 'selected' : '' }}>Sirup</option>
                    <option value="kapsul" {{$medicine ['type'] == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Harga Obat : </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="price" name="price" value="{{$medicine['price']}}">
            </div>
        </div>
        {{--<div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Stok Tersedia : </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="stock" name="stock" value="{{$medicine('stock')}}">
            </div>
        </div>--}}
        <button type="submit" class="btn btn-primary mt-3">Update Data</button>
    </form>
@endsection
