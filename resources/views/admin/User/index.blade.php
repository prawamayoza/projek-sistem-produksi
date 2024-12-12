@extends('layouts.app')
@section('content')
    <div class="main-content">
        <div class="section">
            <div class="section-header">
                <h1>Data User</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>Data User</h4>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('user.create') }}" class="btn btn-outline-success btn-lg d-flex align-items-center">
                                            <i class="fa fa-plus pr-2"></i>
                                            Tambah
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Status Akun</th>
                                                <th>Role</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>
                                                        <input type="checkbox" class="toggle-status" data-id="{{ $item->id }}" 
                                                            {{ $item->is_active ? 'checked' : '' }} data-toggle="toggle"
                                                            data-onstyle="success" data-offstyle="danger" data-width="60"
                                                            data-height="30" @if(auth()->id() == $item->id) disabled @endif>
                                                    </td>
                                                    <td>
                                                        @foreach($item->getRoleNames() as $role)
                                                            {{ $role }}
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('user.show', $item->id) }}" title="Detail" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('user.edit', $item->id) }}" title="Edit" class="btn btn-sm btn-outline-warning">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <button type="button" data-url="{{ route('user.destroy', $item->id) }}" 
                                                            class="btn btn-sm btn-outline-danger delete" title="Hapus"
                                                            @if(auth()->id() == $item->id) disabled @endif>
                                                            <i class="fas fa-trash"></i>
                                                        </button>
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // Initialize Bootstrap Toggle
            $('.toggle-status').bootstrapToggle();

            // AJAX Setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Delete Button Handler
            $(document).on('click', '.delete', function() {
                let url = $(this).data('url');

                swal({
                    title: "Apakah anda yakin?",
                    text: "Setelah dihapus, Anda tidak dapat memulihkan data ini lagi!",
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
                    },
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "DELETE",
                            url: url,
                            success: function(response) {
                                swal(response.status, {
                                    icon: "success",
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                swal("Terjadi kesalahan", {
                                    icon: "error",
                                });
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
