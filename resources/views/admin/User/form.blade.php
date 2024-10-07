@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section">
                <div class="section-header">
                    <div class="section-header-back">
                        <a href="{{ route('user.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                    </div>
                    <h1>
                        @if (@$user->exists)
                            Edit
                            @php
                                $aksi = 'Edit';
                            @endphp
                        @else
                            Tambah
                            @php
                                $aksi = 'Tambah';
                            @endphp
                        @endif
                        Data user
                    </h1>
                </div>
                @if (@$user->exists)
                    <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                        action="{{ route('user.update', $user) }}">
                        @method('put')
                    @else
                        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                            action="{{ route('user.store') }}">
                @endif
                {{ csrf_field() }}
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header">Form User</h5>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label for="name" class="col-md-2 col-form-label">Nama <sup
                                                class="text-danger">*</sup></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" placeholder="Masukan Nama"
                                                value="{{ old('name', @$user->name) }}">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">
                                                    {{ $errors->first('name') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="email" class="col-md-2 col-form-label">Email <sup
                                                class="text-danger">*</sup></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" placeholder="Masukan Email"
                                                value="{{ old('email', @$user->email) }}">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">
                                                    {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="departemen" class="col-md-2 col-form-label">Departemen <sup
                                                class="text-danger">*</sup></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('departemen') is-invalid @enderror"
                                                id="departemen" name="departemen" placeholder="Masukan Departemen"
                                                value="{{ old('departemen', @$user->departemen) }}">
                                            @if ($errors->has('departemen'))
                                                <span class="text-danger">
                                                    {{ $errors->first('departemen') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label for="role" class="col-md-2 col-form-label">Role</label>
                                        <div class="col-md-10">
                                            <select name="role" class="form-control selectric @error('role') is-invalid @enderror">
                                                <option value="" selected disabled>Pilih Hak Akses</option>
                                            
                                                @forelse ($role as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('role', isset($user) && $user->hasRole($item->id)) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @empty
                                                    <option value="{{ $item->id }}"
                                                        {{ old('role', isset($user) ? $user->role : '') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforelse
                                            </select>
                                            
                                            
                                            @error('role')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12 ">
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        {{ $aksi }}
                                        <span class="spinner-border ml-2 d-none" id="loader"
                                            style="width: 1rem; height: 1rem;" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $('#myForm').submit(function(e) {
            let form = this;
            e.preventDefault();

            confirmSubmit(form);
        });
        // Form
        function confirmSubmit(form, buttonId) {
            Swal.fire({
                icon: 'question',
                text: 'Apakah anda yakin ingin menyimpan data ini ?',
                showCancelButton: true,
                buttonsStyling: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    let button = 'btnSubmit';

                    if (buttonId) {
                        button = buttonId;
                    }

                    $('#' + button).attr('disabled', 'disabled');
                    $('#loader').removeClass('d-none');

                    form.submit();
                }
            });
        }

        document.getElementById('kontak').addEventListener('input', function(evt) {
            var input = evt.target;
            input.value = input.value.replace(/[^0-9]/g, ''); // Hanya membiarkan angka
        });
    </script>
@endsection
