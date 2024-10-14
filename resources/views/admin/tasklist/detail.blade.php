@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('task.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Detail Data Tasklist</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <!-- Card for Tasklist Data -->
                        <div class="card">
                            <h5 class="card-header">Data Tasklist</h5>
                            <div class="card-body">

                                <div class="mb-3 row">
                                    <label for="name" class="col-md-2 col-form-label">Nama Tasklist</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Masukan Nama"
                                            value="{{ old('name', @$task->name) }}" disabled>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="projek_id" class="col-md-2 col-form-label">Nama Projek</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control @error('projek_id') is-invalid @enderror"
                                            id="projek_id" name="projek_id" placeholder="Masukan projek_id"
                                            value="{{ old('projek_id', @$task->projek->name) }}" disabled>
                                        @if ($errors->has('projek_id'))
                                            <span class="text-danger">{{ $errors->first('projek_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="user_id" class="col-md-2 col-form-label">Penanggung Jawab</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control @error('user_id') is-invalid @enderror"
                                            id="user_id" name="user_id" placeholder="Masukan user->id"
                                            value="{{ old('user_id', @$task->user->name) }}" disabled>
                                        @if ($errors->has('user_id'))
                                            <span class="text-danger">{{ $errors->first('user_id') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="tanggal" class="col-md-2 col-form-label">Tanggal Dibuat</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control @error('created_at') is-invalid @enderror"
                                            id="created_at" name="created_at" placeholder="Masukan created_at"
                                            value="{{ old('created_at', @$task->created_at->format('Y-m-d')) }}" disabled>
                                        @if ($errors->has('created_at'))
                                            <span class="text-danger">{{ $errors->first('created_at') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="tanggal" class="col-md-2 col-form-label">Tanggal Deadline</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control @error('tanggal') is-invalid @enderror"
                                            id="tanggal" name="tanggal" placeholder="Masukan tanggal"
                                            value="{{ old('tanggal', @$task->tanggal) }}" disabled>
                                        @if ($errors->has('tanggal'))
                                            <span class="text-danger">{{ $errors->first('tanggal') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="status" class="col-md-2 col-form-label">Status</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control @error('status') is-invalid @enderror"
                                            id="status" name="status" placeholder="Masukan status"
                                            value="{{ old('status', @$task->status) }}" disabled>
                                        @if ($errors->has('status'))
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="file" class="col-md-2 col-form-label">File</label>
                                    <div class="col-md-10">
                                        @if(!empty($task->file))
                                            <a href="{{ asset('storage/' . $task->file) }}" class="btn btn-primary" target="_blank">Unduh File</a>
                                        @else
                                            <p>Tidak ada file yang diunggah.</p>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Card for Comments -->
                        <div class="card mt-4">
                            <h5 class="card-header">Daftar Komentar</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="myTable">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Komentar</th>
                                                <th class="text-center">Pengguna</th>
                                                <th class="text-center">Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($task->comment as $comment)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $comment->comment }}</td>
                                                    <td>{{ $comment->user->name }}</td>
                                                    <td>{{ $comment->created_at->format('Y-m-d ') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
