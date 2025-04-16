@extends('layouts.template')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="index.html" class="link"><i
                                        class="mdi mdi-home-outline fs-4"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">User</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">User</h1>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-end">
                                <a href=" {{ route('users.create') }} " class="btn btn-primary text-white">Tambah User</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($users as $item )
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $no++ }}</th>
                                            <td>{{ $item->email }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->role }}</td>
                                                <td>
                                                    <a href="{{ route('users.edit', $item['id']) }}"
                                                    class="btn btn-warning">Edit</a>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#confirmDeleteModal-{{ $item['id'] }}">Hapus</button>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="confirmDeleteModal-{{ $item['id'] }}" tabindex="-1"
                                            aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="confirmDeleteModalLabel">Konfirmasi
                                                            hapus</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Yakin ingin menghapus data ini?
                                                            <br>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <form action="{{ route('users.destroy', $item['id']) }}"
                                                                method="POST">
                                                                @csrf
                                                                @if (session('success'))
                                                                <script>
                                                                    window.onload = function () {
                                                                        setTimeout(() => {
                                                                            Swal.fire({
                                                                                title: 'Sukses!',
                                                                                text: "{{ session('success') }}",
                                                                                icon: 'success',
                                                                                confirmButtonText: 'OK'
                                                                            });
                                                                        }, 500);
                                                                    };
                                                                </script>
                                                                @endif

                                                                @if ($errors->any())
                                                                    <div class="alert alert-danger">
                                                                        {{ $errors->first() }}
                                                                    </div>
                                                                @endif
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
