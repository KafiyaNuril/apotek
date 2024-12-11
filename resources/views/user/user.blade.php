@extends('layouts.layout')

@section('content')
{{-- Session::get() digunakan untuk mengambil data dari session. --}}
    @if (Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="container">
        <div class="d-flex">
            <a href="{{ route('user.tambah') }}" class="btn btn-primary me-2 mb-2">Tambah Akun</a>
            <form action="{{ route('user.data') }}" role="search" class="d-flex me-2" method="GET">
                <input type="text" class="form-control me-2 mb-2" name="search_data" placeholder="Search Data" aria-label="Search">
                <button class=" btn btn-outline-success mb-2" type="submit">Search</button>
            </form>
            <a href="{{ route('user.export') }}" class="btn btn-success mb-2">Export Excel</a>
        </div>

        <table class="table table-bordered table-stripped mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (count($users) < 1)
                    <tr>
                        <td colspan="6" class="text-center">Data User Kosong</td>
                    </tr>
                @else
                    @foreach ($users as $index => $item)
                        <tr>
                            {{-- <td>{{ ($users->currentPage() - 1) * $users->perPage() + ($index + 1) }}</td> --}}
                            <td>{{ ($users->currentPage()-1) * ($users->perPage()) + ($index+1) }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['email'] }}</td>
                            <td>{{ $item['role'] }}</td>
                            <td class="d-flex">
                                <a href={{route('user.edit', $item['id'])}} class="btn btn-primary me-2">Edit</a>
                                <button class="btn btn-danger btn-sm"
                                    onclick="showModal('{{ $item->id }}', '{{ $item->name }}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

        {{--modal hapus--}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-delete-akun" method="POST">
                @csrf
                {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
                method untul menghapus data---}}
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus Akun ini <span id="nama-akun"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-danger" id="confirm-delete">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        {{-- links : memunculkan buttton pagination --}}
        {{ $users->links() }}
    </div>
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        function showModal(id, name) {
            // ini untuk url deletenya (Route)
            let urlDelete = "{{ route('user.hapus', ':id') }}";
            urlDelete = urlDelete.replace(':id', id);
            // ini untuk actin attributenya
            $('#form-delete-akun').attr('action', urlDelete);
            // ini untuk show Modalnya
            $('#exampleModal').modal('show');
            // ini untuk mengisi modalnya
            $('#nama-akun').text(name);
        }
    </script>
@endpush
