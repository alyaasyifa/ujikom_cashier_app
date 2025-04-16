@extends('layouts.template')

@section('content')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                      <li class="breadcrumb-item"><a href="index.html" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
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
                        <form action="{{ route('users.update', $user['id']) }}" method="POST" class="form-horizontal form-material mx-2">
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
                                        }).then(() => {
                                            window.location.href = "{{ route('users.index') }}";
                                        });
                                    }, 500);
                                };
                            </script>
                            @endif

                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email"
                                                class="form-control form-control-line" name="email"  value="{{ $user['email'] }}" id="email">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12">Nama</label>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control form-control-line" value="{{ $user['name'] }}" id="name" name="name">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-12">Password</label>
                                        <div class="col-md-12">
                                            <input type="password" class="form-control form-control-line" id="password" name="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-12">Select User</label>
                                        <div class="col-sm-12">
                                            <select name="role" id="role" class="form-select shadow-none form-control-line">
                                                <option value="admin" {{ $user['role'] == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="kasir" {{ $user['role'] == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol di ujung kanan -->
                            <div class="form-group">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary text-white">Ubah Data</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
