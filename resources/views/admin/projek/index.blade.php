@extends('layouts.app')
@section('content')
    <div class="main-content">
        <div class="section">
            <div class="section-header">
                <h1>Data Project</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4>
                                        Data Project
                                    </h4>
                                    @role('admin')
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('projek.create') }}"
                                                class="btn btn-outline-success btn-lg d-flex align-items-center ">
                                                <i class="fa fa-plus pr-2"></i>
                                                Tambah
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
                                                <th class="px-2" style="width: 10%">
                                                    No
                                                </th>
                                                <th class="text-center px-2">
                                                    Nama
                                                </th>
                                                <th class="text-center px-2">
                                                    Tanggal
                                                </th>
                                                <th class="text-center px-2">
                                                    Deskripsi
                                                </th>
                                                <th class="text-center px-2">
                                                    Status
                                                </th>
                                                <th class="text-center px-2">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($projek as $item)
                                                <tr>
                                                    <td class="px-2">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="text-center px-2">
                                                        {{ $item->name }}
                                                    </td>
                                                    <td class="text-center px-2">
                                                        {{ $item->tanggal }}
                                                    </td>
                                                    <td class="text-center px-2">
                                                        {{$item->deskripsi}}
                                                    </td>
                                                    <td class="text-center px-2">
                                                        {{$item->status}}
                                                    </td>
                                                    <td class="text-center px-2">
                                                        <a href="{{ route('projek.show', $item->id) }}" title="Detail"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                       @role('admin') 
                                                            <a href="{{ route('projek.edit', $item->id) }}" title="Edit"
                                                                class="btn btn-sm btn-outline-warning">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <button value="{{ route('projek.destroy', $item->id) }}"
                                                                class="btn btn-sm btn-outline-danger delete"
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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


