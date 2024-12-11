@extends('layouts.layout')

@section('content')
<form action="{{ route('login.proses')}}" class="card p-5" method="POST">
    @csrf
    @if (Session::get('failed'))
        <div class="alert alert-danger">{{Session::get('failed')}}</div>
    @endif
    <div class="mb-3">
        <label for="email" class="form-label">Input Email</label>
        <input type="email" name="email" id="email" class="form-control">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Input Password</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Login</button>
</form>
@endsection
