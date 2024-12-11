@extends('layouts.layout')

@section('content')
<div class="Jumbotron py-4 px-5">
    @if(Session::get('failed'))
        <div class="alert alert-danger">
            {{Session::get('failed')}}
        </div>
    @endif
    <h1 class="display-4">
        Selamat Datang {{Auth::user()->name}}
    </h1>
    <hr class="my-4">
    <p>Aplikasi ini digunakan oleh pegawai administrator APOTEK. Digunakan untuk mengelola data obat, penyetokan, juga pembelian (kasir)</p>
</div>
@endsection
