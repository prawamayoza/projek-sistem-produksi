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
                                    <h4>
                                        Data User
                                    </h4>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('user.create') }}"
                                            class="btn btn-outline-success btn-lg d-flex align-items-center ">
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
                                                <th class="px-2" style="width: 10%">
                                                    No
                                                </th>
                                                <th class="text-center px-2">
                                                    Nama
                                                </th>
                                                <th class="text-center px-2">
                                                    Email
                                                </th>
                                                <th class="text-center px-2">
                                                    Status Akun
                                                </th>
                                                <th class="text-center px-2">
                                                    Role
                                                </th>
                                                <th class="text-center px-2">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user as $item)
                                                <tr>
                                                    <td class="px-2">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="text-center px-2">
                                                        {{ $item->name }}
                                                    </td>
                                                    <td class="text-center px-2">
                                                        {{ $item->email }}
                                                    </td>
                                                    <td class="text-center px-2">
                                                        <input type="checkbox" class="toggle-status" data-id="{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="60" data-height="30"  @if(auth()->id() == $item->id) disabled @endif>
                                                    </td>
                                                    <td class="text-center px-2">
                                                        @foreach($item->getRoleNames() as $role)
                                                        <div class="badge bg-info">{{ $role }}</div>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center px-2">
                                                        <a href="{{ route('user.show', $item->id) }}" title="Detail"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        <a href="{{ route('user.edit', $item->id) }}" title="Edit"
                                                            class="btn btn-sm btn-outline-warning">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <button value="{{ route('user.destroy', $item->id) }}"
                                                            class="btn btn-sm btn-outline-danger delete"
                                                            data-toggle="tooltip" data-placement="top" title="Hapus"
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
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Handle switch change event
            $('.toggle-status').change(function() {
                let userId = $(this).data('id');
                let url = `/user/${userId}/toggle-status`;
                let state = $(this).prop('checked');
                let confirmMessage = state ? "Apakah anda yakin ingin mengaktifkan akun ini?" : "Apakah anda yakin ingin menonaktifkan akun ini?";
                let switchElement = $(this); // Store switch element

// SweetAlert2 untuk konfirmasi tanpa tombol batal
swal({
    title: "Konfirmasi",
    text: confirmMessage,
    icon: "warning",
    buttons: {
        confirm: {
            text: "Ya",
            value: true,
            visible: true,
            className: "btn-success",
            closeModal: true
        }
    },
    dangerMode: true,
                }).then((willChange) => {
                    if (willChange) {
                        // Jika konfirmasi, lakukan AJAX
                        $.ajax({
                            type: "PATCH",
                            url: url,
                            success: function(response) {
                                swal(response.status, {
                                    icon: "success",
                                });
                            },
                            error: function() {
                                swal("Terjadi kesalahan", {
                                    icon: "error",
                                });
                                // Revert switch if there is an error
                                switchElement.bootstrapToggle('off', true); // Turn off the toggle on error
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.delete', function() {
                let url = $(this).val();
                console.log(url);
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
                        },
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "DELETE",
                                url: url,
                                dataType: 'json',
                                success: function(response) {
                                    swal(response.status, {
                                            icon: "success",
                                        })
                                        .then((result) => {
                                            location.reload();
                                        });
                                }
                            });
                        }
                    });
            }); 
        });
    </script>
@endsection


