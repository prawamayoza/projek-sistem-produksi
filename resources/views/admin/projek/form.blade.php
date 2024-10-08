@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section">
                <div class="section-header">
                    <div class="section-header-back">
                        <a href="{{ route('projek.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                    </div>
                    <h1>
                        @if (@$projek->exists)
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
                        Data projek
                    </h1>
                </div>
                @if (@$projek->exists)
                    <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                        action="{{ route('projek.update', $projek) }}">
                        @method('put')
                    @else
                        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                            action="{{ route('projek.store') }}">
                @endif
                {{ csrf_field() }}
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header">Form projek</h5>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label for="name" class="col-md-2 col-form-label">Nama Projek<sup
                                                class="text-danger">*</sup></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" placeholder="Masukan Nama"
                                                value="{{ old('name', @$projek->name) }}">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">
                                                    {{ $errors->first('name') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="tanggal" class="col-md-2 col-form-label">Tanggal <sup
                                                class="text-danger">*</sup></label>
                                        <div class="col-md-10">
                                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                                id="tanggal" name="tanggal" placeholder="Masukan tanggal"
                                                value="{{ old('tanggal', @$projek->tanggal) }}">
                                            @if ($errors->has('tanggal'))
                                                <span class="text-danger">
                                                    {{ $errors->first('tanggal') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="Deskripsi" class="col-md-2 col-form-label">Deskripsi <sup
                                                class="text-danger">*</sup></label>
                                        <div class="col-md-10">
                                            <textarea name="deskripsi" class="form-control" cols="100" rows="1">{{ old('deskripsi', @$projek->deskripsi) }}</textarea>
                                            @if ($errors->has('deskripsi'))
                                                <span class="text-danger">
                                                    {{ $errors->first('deskripsi') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label for="role" class="col-md-2 col-form-label">File <sup class="text-danger">*</sup></label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                                    id="file" name="file" placeholder="Masukan file" value="{{ old('file') }}">
                                                
                                                <div class="input-group-append">
                                                    @if (isset($projek) && $projek->file)
                                                        <a href="{{ asset('storage/' . $projek->file) }}" class="btn btn-icon" target="_blank" download style="margin-left: 10px;">
                                                            <i class="fas fa-download"></i>

                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            @error('file')
                                                <span class="invalid-feedback" file="alert">
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
    </script>
@endsection
