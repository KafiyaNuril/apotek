@extends('layouts.layout')

@section('content')
<form action="{{ route('pembelian.store.order')}}" method="POST" class="card mx-auto my-5 d-block p-5">
    @csrf
    @if (Session::get('failed'))
        <div class="alert alert-danger">
            {{Session::get('failed')}}
        </div>
    @endif
    <p>Penanggung Jawab: <b>{{ Auth::user()->name }}</b></p>
    <div class="mb-3 row">
        <label for="name_customer" class="col-sm-2 col-form-label">Nama Pembeli :</label>
        <div class="col-sm-10">
            <input type="text" name="name_customer" id="name_customer" class="form-control">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="medicines" class="col-sm-2 col-form-label">Obat :</label>
        <div class="col-sm-10">
            @if (isset($valueBefore))
                @foreach ($valueBefore['medicines'] as $key => $medicine )
                    <div class="d-flex" id="medicines-{{$key}}">
                        <select name="medicines[]" id="medicines" class="form-select mb-2">
                            @foreach ($medicine as $item)
                                <option value="{{ $item['id'] }}" {{$medicines == $item['id'] ? 'selected' : ''}}>{{$item['name']}} (Stock: {{$item['stock']}})</option>
                            @endforeach
                        </select>
                        @if ($key > 0)
                            <div>
                                <span style="cursor: pointer" class="text-danger p-4" onclick="deleteSelect('medicines-{{$key}}')">X</span>
                            </div>
                        @endif
                    </div>
                    <br>
                @endforeach
            @endif
            <select name="medicines[]" id="medicines" class="form-control">
                <option disabled selected hidden>---Pilih Obat---</option>
                @foreach ($medicines as $medicine)
                    <option value="{{ $medicine['id'] }}">{{ $medicine['name'] }}</option>
                @endforeach
            </select>

            <div id="medicines-wrap"></div> {{--untuk menampung penambahan obat--}}
            <br>
            <p style="cursor: pointer" class="text-primary" id="add-select">+ Tambah</p>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Konfirmasi Pembelian</button>
</form>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    let no = 2;

    $("#add-select").on("click", function () {
        // ini diisi dengan tag html yang nantinya ditambahkan/dimunculkan
        let html = `<div class="d-flex mt-2" id="medicines-${no}">
            <br>
            <select name="medicines[]" id="medicines" class="form-select">
                <option disabled selected hidden>Pesanan ${no}</option>
                @foreach ($medicines as $item)
                    <option value="{{ $item['id'] }}">{{ $item['name'] }} (Stock: {{$item['stock']}})</option>
                @endforeach
            </select>
            <div>
                <span style="cursor: pointer" class="text-danger p-4" onclick="deleteSelect('medicines-${no}')">X</span>
            </div>
            </div>`

            // fungsi append ini digunakan untuk menambahkan tag html diatas
        $("#medicines-wrap").append(html);
        no++;
    })

    function deleteSelect(id) {
        $(`#${id}`).remove();
        $no--;
    }
</script>
@endpush
