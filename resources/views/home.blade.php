@extends('layouts.app')

@section('content')
<style>
    .ticket-details {
        padding: 10px;
    }

    .detail-row {
        display: flex;
        margin-bottom: 5px;
    }

    .detail-label {
        flex: 1;
        font-weight: bold;
    }

    .detail-value {
        flex: 3;
    }

    .divider {
        border-top: 1px solid #6c757d;
        margin: 10px 0;
    }

    .dynamic-card {
        flex: 1;
        margin-bottom: 20px;
    }

    /* Position the badge bubble */
    .nav-link {
        position: relative;
    }

    /* Style for the badge bubble */
    .badge {
        position: absolute;
        top: -5px; /* Adjust vertical position */
        right: 2px; /* Adjust horizontal position */
        padding: 5px;
        font-size: 0.75rem;
        border-radius: 50%;
        background-color: #dc3545; /* Red background for the bubble */
        color: #fff;
        font-weight: bold;
    }

</style>

<div class="main-content">
    <section class="section">
        <div class="row">
            <!-- Order Statistics -->
            <div class="col-lg-4 col-md-4 col-sm-12 dynamic-card">
                <div class="card card-statistic-2">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Project</h4>
                        </div>
                        <div class="card-body">
                            {{$countAll}}
                        </div>
                    </div>
                    <div class="card-stats">
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$countPending}}</div>
                                <div class="card-stats-item-label">
                                    Pending
                                    <!-- Tooltip for Pending -->
                                    <div class="tooltip">{{$countPending}} project pending.</div>
                                </div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$countInprogres}}</div>
                                <div class="card-stats-item-label">
                                    In Progres
                                    <!-- Tooltip for In Progres -->
                                    <div class="tooltip">{{$countInprogres}} project In Progres.</div>
                                </div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">{{$countCompleted}}</div>
                                <div class="card-stats-item-label">
                                    Completed
                                    <!-- Tooltip for Completed -->
                                    <div class="tooltip">{{$countCompleted}} project completed.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>

            <!-- Total Tasklist -->
            <div class="col-lg-4 col-md-4 col-sm-12 dynamic-card">
                <div class="card card-statistic-2">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Tasklist</h4>
                        </div>
                        <div class="card-body">
                            {{$countTask}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total User -->
            @role('admin||c.level')
            <div class="col-lg-4 col-md-4 col-sm-12 dynamic-card">
                <div class="card card-statistic-2">
                    
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total User</h4>
                        </div>
                        <div class="card-body">
                            {{$countUser}}
                        </div>
                    </div>
                </div>
            </div>
            @endrole
        </div>

        <!-- Data Aktivitas Projek -->
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between w-100">
                    <h4>Data Aktivitas Tasklist</h4>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="projekTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="projek-berjalan-tab" data-toggle="tab" href="#projek-berjalan" role="tab" aria-controls="projek-berjalan" aria-selected="true">
                            Tasklist Berjalan
                            <span class="badge badge-danger" id="projek-berjalan-count">{{$countBerjalan}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="projek-selesai-tab" data-toggle="tab" href="#projek-selesai" role="tab" aria-controls="projek-selesai" aria-selected="false">
                            Tasklist Selesai
                            <span class="badge badge-danger" id="projek-selesai-count">{{$countSelesai}}</span>
                        </a>
                    </li>
                </ul>                
                <div class="tab-content mt-3" id="projekTabContent">
                    <!-- Projek Berjalan Tab -->
                    <div class="tab-pane fade show active" id="projek-berjalan" role="tabpanel" aria-labelledby="projek-berjalan-tab">
                        <div class="table-responsive">
                            <table class="table table-striped" id="myTable1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="text-center">Nama Penanggung</th>
                                        <th class="text-center">Projek</th>
                                        <th class="text-center">Tasklist</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projekBerjalan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->user->name }}</td>
                                            <td class="text-center">{{ $item->tasklist->projek->name }}</td>
                                            <td class="text-center">{{ $item->tasklist->name }}</td>
                                            <td class="text-center">{{ $item->status }}</td>
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
                                        <th>No</th>
                                        <th class="text-center">Nama Penanggung Jawab</th>
                                        <th class="text-center">Projek</th>
                                        <th class="text-center">Tasklist</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projekSelesai as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->user->name }}</td>
                                            <td class="text-center">{{ $item->tasklist->projek->name }}</td>
                                            <td class="text-center">{{ $item->tasklist->name }}</td>
                                            <td class="text-center">{{ $item->status }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
