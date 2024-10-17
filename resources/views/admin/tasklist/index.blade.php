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
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>Data Tasklist</h4>
                                    @role('admin')
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('task.create') }}" class="btn btn-outline-success btn-lg d-flex align-items-center ">
                                                <i class="fa fa-plus pr-2"></i> Tambah
                                            </a>
                                        </div>
                                    @endrole    
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="myTable">
                                        <thead>
                                            <tr>
                                                <th class="px-2" style="width: 10%">#</th>
                                                <th class="text-center px-2">Nama Task</th>
                                                <th class="text-center px-2">Nama Projek</th>
                                                <th class="text-center px-2">Penanggung jawab</th>
                                                <th class="text-center px-2">Tanggal Dibuat</th>
                                                <th class="text-center px-2">Tanggal Deadline</th>
                                                <th class="text-center px-2">Status</th>
                                                <th class="text-center px-2">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($task as $item)
                                                <tr>
                                                    <td class="px-2">{{ $loop->iteration }}</td>
                                                    <td class="text-center px-2">{{ $item->name }}</td>
                                                    <td class="text-center px-2">{{ $item->projek->name }}</td>
                                                    <td class="text-center px-2">{{ $item->user->name }}</td>
                                                    <td class="text-center px-2">{{ $item->created_at->format('Y-m-d') }}</td>
                                                    <td class="text-center px-2">{{ $item->tanggal }}</td>
                                                    <td class="text-center px-2">{{ $item->status }}</td>
                                                    <td class="text-center px-2">
                                                        <a href="{{ route('task.show', $item->id) }}" title="Detail" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @role('c.level')
                                                            <button class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#commentModal" 
                                                                data-task-id="{{ $item->id }}" title="Komentar Tasklist">
                                                                <i class="fas fa-comment"></i>
                                                            </button>
                                                        @endrole
                                                        @role('peg.produksi')
                                                            <button class="btn btn-sm btn-outline-success" data-toggle="modal" 
                                                                data-target="#uploadFileModal" data-task-id="{{ $item->id }}">
                                                                <i class="fas fa-upload"></i>
                                                            </button>
                                                        @endrole
                                                        @role('admin')
                                                        <a href="{{ route('task.edit', $item->id) }}" title="Edit" class="btn btn-sm btn-outline-warning">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <button value="{{ route('task.destroy', $item->id) }}" class="btn btn-sm btn-outline-danger delete"
                                                            data-toggle="tooltip" data-placement="top" title="Hapus">
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
                        <!-- Input for File Upload -->
                        <div class="form-group">
                            <label for="files">Upload Dokumen PDF:</label>
                            <input type="file" class="form-control" id="files" name="files[]" accept="application/pdf" multiple>
                            @error('files')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Input for URL Links -->
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

            // Buka modal dan isi task_id ke dalam form
            $('#commentModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var taskId = button.data('task-id');
                var modal = $(this);
                modal.find('.modal-body #tasklist_id').val(taskId);
            });

            // Handle form submission via AJAX for comments
            $('#commentForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
              
                $.ajax({
                    type: "POST",
                    url: "{{ route('task.comment') }}", // Route untuk menyimpan komentar
                    data: formData,
                    success: function(response) {
                        $('#commentModal').modal('hide');
                        swal(response.status, {
                            icon: "success",
                        }).then((result) => {
                            location.reload(); // Refresh halaman setelah komentar ditambahkan
                        });
                    },
                    error: function(response) {
                        console.log(response);
                        swal("Error", "There was an issue submitting your comment.", "error");
                    }
                });
            });

            // Existing delete function
            $(document).on('click', '.delete', function() {
                let url = $(this).val();
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
                            type: 'DELETE',
                            url: url,
                            success: function(response) {
                                swal(response.status, {
                                    icon: "success",
                                }).then((result) => {
                                    location.reload(); // Refresh halaman setelah data dihapus
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

            // Buka modal upload dan isi task_id ke dalam form
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
