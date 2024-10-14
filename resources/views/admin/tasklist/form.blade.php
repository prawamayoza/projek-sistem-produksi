@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section">
                <div class="section-header">
                    <div class="section-header-back">
                        <a href="{{ route('task.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                    </div>
                    <h1>
                        @if (@$task->exists)
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
                        Data Tasklist
                    </h1>
                </div>
                @if (@$task->exists)
                    <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                        action="{{ route('task.update', $task) }}">
                        @method('put')
                    @else
                        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                            action="{{ route('task.store') }}">
                @endif
                {{ csrf_field() }}
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header">Form Tasklist</h5>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label for="name" class="col-md-2 col-form-label">Nama task<sup
                                                class="text-danger">*</sup></label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" placeholder="Masukan Nama"
                                                value="{{ old('name', @$task->name) }}">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">
                                                    {{ $errors->first('name') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="projek_id" class="col-md-2 col-form-label">Projek<sup class="text-danger">*</sup></label>
                                        <div class="col-md-10">
                                            <select name="projek_id" id="projek_id" class="form-control selectric @error('projek_id') is-invalid @enderror">
                                                <option value="" selected disabled>Pilih Projek</option>
                                                @foreach ($projek as $item)
                                                    <option value="{{ $item->id }}" {{ old('projek_id', @$task->projek_id) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                    
                                            @if ($errors->has('projek_id'))
                                                <span class="text-danger">
                                                    {{ $errors->first('projek_id') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="user_id" class="col-md-2 col-form-label">Penanggung Jawab <sup class="text-danger">*</sup></label>
                                        <div class="col-md-10">
                                            <select name="user_id" id="user_id" class="form-control selectric @error('user_id') is-invalid @enderror">
                                                <option value="" selected disabled>Pilih Penanggung Jawab</option>
                                                @foreach ($user as $item)
                                                    <option value="{{ $item->id }}" {{ old('user_id', @$task->user_id) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                    
                                            @if ($errors->has('user_id'))
                                                <span class="text-danger">
                                                    {{ $errors->first('user_id') }}
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
                                                value="{{ old('tanggal', @$task->tanggal) }}">
                                            @if ($errors->has('tanggal'))
                                                <span class="text-danger">
                                                    {{ $errors->first('tanggal') }}
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
                                                    @if (isset($task) && $task->file)
                                                        <a href="{{ asset('storage/' . $task->file) }}" class="btn btn-icon" target="_blank" download style="margin-left: 10px;">
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
                                    {{-- ketika form edit field ubah status tampil --}}
                                    @if (@$task->exists)
                                        <div class="mb-3 row">
                                            <label for="status" class="col-md-2 col-form-label">Status<sup class="text-danger">*</sup></label>
                                            <div class="col-md-10">
                                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                                    <option value="Pending" {{ old('status', @$task->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="In Progress" {{ old('status', @$task->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="Completed" {{ old('status', @$task->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('status') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    
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
