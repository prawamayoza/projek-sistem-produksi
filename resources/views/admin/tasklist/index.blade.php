@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="section">
        <div class="section-header">
            <h1>Data Tasklist</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Data Tasklist</h4>
                            @role('admin')
                                <a href="{{ route('task.create') }}" class="btn btn-outline-success">
                                    <i class="fa fa-plus pr-2"></i> Tambah
                                </a>
                            @endrole    
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal mb-3" action="{{ route('task.index') }}" method="GET">
                                <div class="row align-items-center mb-3 ml-1">
                                    <label for="projek_id" class="label-control">Filter Projek</label>
                                    <div class="col-md-3 col-sm-6"> 
                                        <select name="projek_id" id="projek_id" class="form-control selectric">
                                            <option value="">Pilih Projek</option>
                                            @foreach ($projek as $item)
                                                <option value="{{ $item->id }}" {{ request('projek_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-6 d-flex align-items-center">
                                        <button id="btn-submit-filter" type="submit" class="btn btn-outline-success mr-2">
                                            <i class="fa fa-filter" aria-hidden="true"></i> FILTER
                                        </button>

                                        <a href="{{ route('task.index') }}" class="btn btn-outline-secondary ">
                                            <i class="fa fa-times" aria-hidden="true"></i> RESET
                                        </a>
                                    </div>
                                </div>
                            </form> 
                            <div class="table-responsive">
                                <table class="table table-striped" id="myTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Tasklist</th>
                                            <th class="text-center">Nama Projek</th>
                                            <th class="text-center">Penanggung jawab</th>
                                            <th class="text-center">Tanggal Dibuat</th>
                                            <th class="text-center">Tanggal Deadline</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($task as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $item->name }}</td>
                                                <td class="text-center">
                                                    @if(optional(@$item->projek)->name)
                                                        {{ @$item->projek->name }}
                                                    @else
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Data projek sudah terhapus, silahkan cek data projek.">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $item->user->name }}</td>
                                                <td class="text-center">{{ $item->created_at->format('Y-m-d') }}</td>
                                                <td class="text-center">{{ $item->tanggal }}</td>
                                                <td class="text-center">{{ $item->status }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('task.show', $item->id) }}" title="Detail" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @role('c.level')
                                                        <button class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#commentModal" data-task-id="{{ $item->id }}" title="Komentar Tasklist">
                                                            <i class="fas fa-comment"></i>
                                                        </button>
                                                    @endrole
                                                    @role('peg.produksi')
                                                        <button class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#uploadFileModal" data-task-id="{{ $item->id }}">
                                                            <i class="fas fa-upload"></i>
                                                        </button>
                                                    @endrole
                                                    @role('admin')
                                                        <a href="{{ route('task.edit', $item->id) }}" title="Edit" class="btn btn-sm btn-outline-warning">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <button value="{{ route('task.destroy', $item->id) }}" class="btn btn-sm btn-outline-danger delete" data-toggle="tooltip" data-placement="top" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endrole
                                                </td>
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
</div>

<!-- Modal Comment -->
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Tambah Komentar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="commentForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="tasklist_id" id="tasklist_id">
                    <div class="form-group">
                        <label for="comment">Komentar:</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="files">Upload Gambar:</label>
                        <input type="file" class="form-control" id="files" name="files[]" accept="image/jpeg,image/png" multiple>
                        @error('files')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="file_links">Upload Links:</label>
                        <input type="url" class="form-control" id="file_links" name="file_links[]" placeholder="https://example.com" multiple>
                        @error('file_links')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Tambah Komentar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Uploading Files and Links -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFileModalLabel">Upload Dokumen PDF dan Link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadFileForm" action="{{ route('tasklist.uploadFile', ':id') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="tasklist_id" id="uploadTasklistId">
                    <div class="form-group">
                        <label for="files">Upload Dokumen PDF:</label>
                        <input type="file" class="form-control" id="files" name="files[]" accept="application/pdf" multiple>
                        @error('files')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="file_links">Upload Links:</label>
                        <input type="url" class="form-control" id="file_links" name="file_links[]" placeholder="https://example.com" multiple>
                        @error('file_links')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#commentModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var taskId = button.data('task-id');
            var modal = $(this);
            modal.find('.modal-body #tasklist_id').val(taskId);
        });

        $('#commentForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this); // Gunakan FormData untuk menangani file

            $.ajax({
                type: "POST",
                url: "{{ route('task.comment') }}",
                data: formData,
                contentType: false, // Hindari pengaturan content-type secara otomatis
                processData: false, // Hindari pemrosesan data secara otomatis
                success: function(response) {
                    $('#commentModal').modal('hide');
                    swal(response.status, {
                        icon: "success",
                    }).then((result) => {
                        location.reload();
                    });
                },
                error: function(response) {
                    console.log(response);
                    swal("Error", "Data Tidak Lengkap.", "error");
                }
            });
        });

        $(document).on('click', '.delete', function() {
            var url = $(this).val();
            swal({
                title: "Apakah anda yakin?",
                text: "Setelah dihapus, Anda tidak dapat memulihkan Data ini lagi!",
                icon: "warning",
                    buttons: {
                        cancel: "Batal",
                        confirm: {
                            text: "Hapus",
                            value: true,
                            visible: true,
                            className: "btn-danger",
                            closeModal: true
                        }
                    }
                }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        success: function(response) {
                            swal(response.status, {
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(response) {
                            console.log(response);
                                swal("Error", "Data gagal dihapus.", "error");
                        }
                    });
                }
            });
        });

        $('#uploadFileModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var taskId = button.data('task-id');
            var modal = $(this);
                modal.find('#uploadTasklistId').val(taskId);
                var action = $(this).find('form').attr('action').replace(':id', taskId);
                $(this).find('form').attr('action', action);
            });

            // Handle form submission via AJAX for file uploads
            $('#uploadFileForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
              
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#uploadFileModal').modal('hide');
                        swal(response.status, {
                            icon: "success",
                        }).then((result) => {
                            location.reload(); // Refresh halaman setelah file diupload
                        });
                    },
                    error: function(response) {
                        console.log(response);
                        swal("Error", "Lengkapi inputan data.", "error");
                    }
                });
        });
    });
</script>
@endsection
