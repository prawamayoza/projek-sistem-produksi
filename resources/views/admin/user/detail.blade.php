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
                        Detail Data User
                    </h1>
                </div>
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header">Data User</h5>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label for="name" class="col-md-2 col-form-label">Nama</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" placeholder="Masukan Nama"
                                                value="{{ old('name', @$user->name) }}" disabled>
                                            @if ($errors->has('name'))
                                                <span class="text-danger">
                                                    {{ $errors->first('name') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="email" class="col-md-2 col-form-label">Email</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" placeholder="Masukan Email"
                                                value="{{ old('email', @$user->email) }}" disabled>
                                            @if ($errors->has('email'))
                                                <span class="text-danger">
                                                    {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="departemen" class="col-md-2 col-form-label">Departemen</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('departemen') is-invalid @enderror"
                                                id="departemen" name="departemen" placeholder="Masukan departemen"
                                                value="{{ old('departemen', @$user->departemen) }}" disabled>
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
                                            <input type="text" class="form-control @error('role') is-invalid @enderror"
                                                id="role" name="role" placeholder="Masukan role"
                                                value="{{ old('role', $roles) }}" disabled>
                                            @if ($errors->has('role'))
                                                <span class="text-danger">
                                                    {{ $errors->first('role') }}
                                                </span>
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
