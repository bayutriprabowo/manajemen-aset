@include('templates.head')

<body class="sb-nav-fixed">
    @include('templates.nav')

    <!-- layout sidenav-->
    <div id="layoutSidenav">
        @include('templates.sidenav')

        <!-- layout content-->
        <div id="layoutSidenav_content">
            <!-- main content-->

            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Transaction Monitoring Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transaction Monitoring Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('monitorings.edit', $id) }}">Edit Monitoring Barang</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan mutasi barang, apabila ada
                            masalah silakan hubungi kewenangan diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Mutasi Barang
                        </div>
                        <div class="card-body">
                            <!-- procurement header -->
                            <table class="table" id="datatables">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Item</th>
                                        <th>Departemen</th>
                                        <th>User</th>
                                        <th>Kode</th>
                                        <th>Periode</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Kuantitas</th>
                                        <th>Biaya</th>
                                        <th>Bukti</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $monitoringForm->id }}</td>
                                        <td>{{ $monitoringForm->transaction_date }}</td>
                                        <td>{{ $monitoringForm->masterItem->name }}</td>
                                        <td>{{ $monitoringForm->masterDepartment->name }}</td>
                                        <td>{{ $monitoringForm->user->name }}</td>
                                        <td>{{ $monitoringForm->code }}</td>
                                        <td>
                                            {{-- {{ $monitoringForm->status }} --}}
                                            @if ($monitoringForm->period == 'daily')
                                                <button class="btn btn-primary btn-sm">Harian</button>
                                            @elseif ($monitoringForm->period == 'weekly')
                                                <button class="btn btn-warning btn-sm">Mingguan</button>
                                            @elseif ($monitoringForm->period == 'monthly')
                                                <button class="btn btn-success btn-sm">Bulanan</button>
                                            @elseif ($monitoringForm->period == 'yearly')
                                                <button class="btn btn-danger btn-sm">Tahunan</button>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- {{ $monitoringForm->status }} --}}
                                            @if ($monitoringForm->status == 'in_progress')
                                                <button class="btn btn-primary btn-sm">Proses</button>
                                            @elseif ($monitoringForm->status == 'postponed')
                                                <button class="btn btn-warning btn-sm">Ditunda</button>
                                            @elseif ($monitoringForm->status == 'completed')
                                                <button class="btn btn-success btn-sm">Selesai</button>
                                            @elseif ($monitoringForm->status == 'cancelled')
                                                <button class="btn btn-danger btn-sm">Dibatalkan</button>
                                            @endif
                                        </td>
                                        <td>{{ $monitoringForm->description }}</td>
                                        <td>{{ $monitoringForm->quantity }}</td>
                                        <td>{{ $monitoringForm->cost }}</td>
                                        <td>
                                            @if ($monitoringForm->photo_proof)
                                                <img src="{{ asset('storage/' . $monitoringForm->photo_proof) }}"
                                                    alt="Photo Proof" style="max-width: 100px; max-height: 100px;">
                                            @else
                                                No Proof Available
                                            @endif
                                        </td>
                                        <td>

                                            @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                                                @if ($monitoringForm->status != 'in_progress')
                                                    <a href="#" class="btn btn-primary"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to process this movement?')) { document.getElementById('process-monitoring-{{ $monitoringForm->id }}').submit(); }"><i
                                                            class="fa-solid fa-play" aria-hidden="true"></i></a>
                                                @endif
                                            @endif

                                            @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                                                @if ($monitoringForm->status != 'completed')
                                                    <a href="#" class="btn btn-success"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to complete this movement?')) { document.getElementById('complete-monitoring-{{ $monitoringForm->id }}').submit(); }"><i
                                                            class="fa fa-check-circle" aria-hidden="true"></i></a>
                                                @endif
                                            @endif

                                            @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                                                @if ($monitoringForm->status != 'postponed')
                                                    <a href="#" class="btn btn-warning"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to postpone this movement?')) { document.getElementById('postpone-monitoring-{{ $monitoringForm->id }}').submit(); }"><i
                                                            class="fa fa-ban" aria-hidden="true"></i></i></a>
                                                @endif
                                            @endif

                                            {{-- <a class="btn btn-warning" href="{{ route('vendors.edit', $vendor->id) }}">edit</a> --}}
                                            @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                                                @if ($monitoringForm->status != 'cancelled')
                                                    <a href="#" class="btn btn-danger"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to cancel this movement?')) { document.getElementById('cancel-monitoring-{{ $monitoringForm->id }}').submit(); }"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></a>
                                                @endif
                                            @endif


                                            <form id="complete-monitoring-{{ $monitoringForm->id }}"
                                                action="{{ route('monitorings.complete', $monitoringForm->id) }}"
                                                method="POST" style="display: none;">
                                                <input name="status" type="text" value="completed">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <form id="postpone-monitoring-{{ $monitoringForm->id }}"
                                                action="{{ route('monitorings.postpone', $monitoringForm->id) }}"
                                                method="POST" style="display: none;">
                                                <input name="status" type="text" value="postponed">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <form id="process-monitoring-{{ $monitoringForm->id }}"
                                                action="{{ route('monitorings.process', $monitoringForm->id) }}"
                                                method="POST" style="display: none;">
                                                <input name="status" type="text" value="in_progress">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <form id="cancel-monitoring-{{ $monitoringForm->id }}"
                                                action="{{ route('monitorings.cancel', $monitoringForm->id) }}"
                                                method="POST" style="display: none;">
                                                <input name="status" type="text" value="cancelled">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </td>
                                    </tr>


                                </tbody>

                            </table>
                            <!-- end header -->

                            <!-- procurement detail -->
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Item</th>
                                        <th>Departemen</th>
                                        <th>Keterangan</th>
                                        <th>Kuantitas</th>
                                        <th>Biaya</th>
                                        <th>Bukti</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Item</th>
                                        <th>Departemen</th>
                                        <th>Keterangan</th>
                                        <th>Kuantitas</th>
                                        <th>Biaya</th>
                                        <th>Bukti</th>

                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($monitoringLogs as $log)
                                        <tr>
                                            <td>{{ $log->id }}</td>
                                            <td>{{ $log->transaction_date }}</td>
                                            <td>{{ $log->masterItem->name }}</td>
                                            <td>{{ $log->masterDepartment->name }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->quantity }}</td>
                                            <td>{{ $log->cost }}</td>
                                            <td>
                                                @if ($log->photo_proof)
                                                    <img src="{{ asset('storage/' . $log->photo_proof) }}"
                                                        alt="Photo Proof" style="max-width: 100px; max-height: 100px;">
                                                @else
                                                    No Proof Available
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <!-- end detail -->

                        </div>
                    </div>
                </div>
            </main>






            @include('templates.footer')
        </div>
        <!-- end layout content-->
    </div>
    <!-- end layout sidenav -->
    @include('templates.script')
</body>

</html>
