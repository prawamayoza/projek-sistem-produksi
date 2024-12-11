@extends('layouts.app')
@section('content')
<div class="main-content">
    <div class="section">
        <div class="section-header">
            <h1>Data Aktivitas User</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>Data Aktivitas Projek</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="projekTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="projek-berjalan-tab" data-toggle="tab" href="#projek-berjalan" role="tab" aria-controls="projek-berjalan" aria-selected="true">Projek Berjalan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="projek-selesai-tab" data-toggle="tab" href="#projek-selesai" role="tab" aria-controls="projek-selesai" aria-selected="false">Projek Selesai</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="projekTabContent">
                                <!-- Projek Berjalan Tab -->
                                <div class="tab-pane fade show active" id="projek-berjalan" role="tabpanel" aria-labelledby="projek-berjalan-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="myTable1">
                                            <thead>
                                                <tr>
                                                    <th class="px-2" style="width: 10%">No</th>
                                                    <th class="text-center px-2">Nama Penanggung</th>
                                                    <th class="text-center px-2">Projek</th>
                                                    <th class="text-center px-2">Tasklist</th>
                                                    <th class="text-center px-2">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($projekBerjalan as $item)
                                                    <tr>
                                                        <td class="px-2">{{ $loop->iteration }}</td>
                                                        <td class="text-center px-2">{{ $item->user->name }}</td>
                                                        <td class="text-center px-2">{{ $item->tasklist->projek->name }}</td>
                                                        <td class="text-center px-2">{{ $item->tasklist->name }}</td>
                                                        <td class="text-center px-2">{{ $item->status }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Projek Selesai Tab -->
                                <div class="tab-pane fade" id="projek-selesai" role="tabpanel" aria-labelledby="projek-selesai-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th class="px-2" style="width: 10%">No</th>
                                                    <th class="text-center px-2">Nama Penanggung Jawab</th>
                                                    <th class="text-center px-2">Projek</th>
                                                    <th class="text-center px-2">Tasklist</th>
                                                    <th class="text-center px-2">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($projekSelesai as $item)
                                                    <tr>
                                                        <td class="px-2">{{ $loop->iteration }}</td>
                                                        <td class="text-center px-2">{{ $item->user->name }}</td>
                                                        <td class="text-center px-2">{{ $item->tasklist->projek->name }}</td>
                                                        <td class="text-center px-2">{{ $item->tasklist->name }}</td>
                                                        <td class="text-center px-2">{{ $item->status }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- End of tab-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
