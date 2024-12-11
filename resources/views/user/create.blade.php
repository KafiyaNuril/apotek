@extends('layouts.layout')

@section('content')
    <form action="{{route('user.tambah.formulir')}}" method="POST" class="card p-5">
        @csrf {{--token keamanan CSRF akan disertakan sebagai bagian dari permintaan. Membantu Laravel memverifikasi bahwa permintaan tersebut berasal dari pengguna yang sah--}}
        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}</div>
        @endif
        {{--fungsi any() untuk mengecek apakah ada error--}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $errors)
                        <li>{{ $errors }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama" value="{{ old('name') }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukan Email" value="{{ old('email') }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password" value="{{ old('password') }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Role:</label>
            <div class="col-sm-10">
                <select class="form-select" id="role" name="role">
                    <option selected disabled hidden>Pilih</option>
                    {{--old() ==> mengambil masukan lama dari permintaan sebelumnya--}}
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Kasir</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
    </form>
@endsection
