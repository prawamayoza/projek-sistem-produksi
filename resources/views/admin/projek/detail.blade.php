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
                        Detail Data Projek
                    </h1>
                </div>
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header">Data Projek</h5>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label for="name" class="col-md-2 col-form-label">Nama Projek</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" placeholder="Masukan Nama"
                                                value="{{ old('name', @$projek->name) }}" disabled>
                                            @if ($errors->has('name'))
                                                <span class="text-danger">
                                                    {{ $errors->first('name') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="tanggal" class="col-md-2 col-form-label">Tanggal</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('tanggal') is-invalid @enderror"
                                                id="tanggal" name="tanggal" placeholder="Masukan tanggal"
                                                value="{{ old('tanggal', @$projek->tanggal) }}" disabled>
                                            @if ($errors->has('tanggal'))
                                                <span class="text-danger">
                                                    {{ $errors->first('tanggal') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="deskripsi" class="col-md-2 col-form-label">Deskripsi</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('deskripsi') is-invalid @enderror"
                                                id="deskripsi" name="deskripsi" placeholder="Masukan deskripsi"
                                                value="{{ old('deskripsi', @$projek->deskripsi) }}" disabled>
                                            @if ($errors->has('deskripsi'))
                                                <span class="text-danger">
                                                    {{ $errors->first('deskripsi') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                                                        
                                    <div class="mb-3 row">
                                        <label for="status" class="col-md-2 col-form-label">Status</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('status') is-invalid @enderror"
                                                id="status" name="status" placeholder="Masukan status"
                                                value="{{ old('status', @$projek->status) }}" disabled>
                                            @if ($errors->has('status'))
                                                <span class="text-danger">
                                                    {{ $errors->first('status') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label for="file" class="col-md-2 col-form-label">File</label>
                                        <div class="col-md-10">
                                            @if(!empty($projek->file))
                                                <a href="{{ asset('storage/' . $projek->file) }}" class="btn btn-primary" target="_blank">Unduh File</a>
                                            @else
                                                <p>Tidak ada file yang diunggah.</p>
                                            @endif
                                        </div>
                                    </div>                                 

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
