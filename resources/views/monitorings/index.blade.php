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
                    <a class="btn btn-success" href="{{ route('monitorings.create') }}">Tambah Tabel Monitoring</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan monitoring, apabila ada
                            masalah silakan hubungi kewenangan diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Monitoring Barang
                        </div>

                        <select name="item" id="item_search" class="form-control item-id mb-3">
                            <option value="">Pilih Item</option>
                            @foreach ($masterItems as $item)
                                <option value="{{ $item->id }}" data-nama="{{ $item->name }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="department" id="department_search" class="form-control item-id mb-3">
                            <option value="">Pilih Departemen</option>
                            @foreach ($masterDepartments as $department)
                                <option value="{{ $department->id }}" data-nama="{{ $department->name }}">
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>

                        <div class="card-body">
                            <table id="datatablesSimple">
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
                                <tfoot>
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
                                </tfoot>
                                <tbody>
                                    @php
                                        use Carbon\Carbon;
                                    @endphp
                                    @foreach ($monitoringForms as $form)
                                        @php

                                            $transactionDate = Carbon::parse($form->transaction_date);
                                            $transactionDate->setTimezone('Asia/Jakarta');
                                            $currentDate = Carbon::now();
                                            $currentDate->setTimeZone('Asia/Jakarta');

                                            $isDayPassed = $transactionDate->diffInDays($currentDate) >= 1;
                                            $isWeekPassed = $transactionDate->diffInWeeks($currentDate) >= 1;
                                            $isMonthPassed = $transactionDate->diffInMonths($currentDate) >= 1;
                                            $isYearPassed = $transactionDate->diffInYears($currentDate) >= 1;
                                        @endphp

                                        <tr>
                                            <td>{{ $form->id }}</td>
                                            <td>{{ $form->transaction_date }}</td>
                                            <td>{{ $form->masterItem->name }}</td>
                                            <td>{{ $form->masterDepartment->name }}</td>
                                            <td>{{ $form->user->name }}</td>
                                            <td>{{ $form->code }}</td>
                                            <td>
                                                {{-- {{ $form->status }} --}}
                                                @if ($form->period == 'daily')
                                                    <button class="btn btn-primary btn-sm">Harian</button>
                                                @elseif ($form->period == 'weekly')
                                                    <button class="btn btn-warning btn-sm">Mingguan</button>
                                                @elseif ($form->period == 'monthly')
                                                    <button class="btn btn-success btn-sm">Bulanan</button>
                                                @elseif ($form->period == 'yearly')
                                                    <button class="btn btn-danger btn-sm">Tahunan</button>
                                                @endif
                                            </td>
                                            <td>
                                                {{-- {{ $form->status }} --}}
                                                @if ($form->status == 'in_progress')
                                                    <button class="btn btn-primary btn-sm">Proses</button>
                                                @elseif ($form->status == 'postponed')
                                                    <button class="btn btn-warning btn-sm">Ditunda</button>
                                                @elseif ($form->status == 'completed')
                                                    <button class="btn btn-success btn-sm">Selesai</button>
                                                @elseif ($form->status == 'cancelled')
                                                    <button class="btn btn-danger btn-sm">Dibatalkan</button>
                                                @endif
                                            </td>
                                            <td>{{ $form->description }}</td>
                                            <td>{{ $form->quantity }}</td>
                                            <td>{{ $form->cost }}</td>
                                            <td>
                                                @if ($form->photo_proof)
                                                    <img src="{{ asset('storage/' . $form->photo_proof) }}"
                                                        alt="Photo Proof" style="max-width: 100px; max-height: 100px;">
                                                @else
                                                    No Proof Available
                                                @endif
                                            </td>
                                            <td>

                                                @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                                                    @if ($form->status != 'in_progress')
                                                        <a href="#" class="btn btn-primary"
                                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to process this movement?')) { document.getElementById('process-monitoring-{{ $form->id }}').submit(); }"><i
                                                                class="fa-solid fa-play" aria-hidden="true"></i></a>
                                                    @endif
                                                @endif

                                                @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                                                    @if ($form->status != 'completed')
                                                        <a href="#" class="btn btn-success"
                                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to complete this movement?')) { document.getElementById('complete-monitoring-{{ $form->id }}').submit(); }"><i
                                                                class="fa fa-check-circle" aria-hidden="true"></i></a>
                                                    @endif
                                                @endif
                                                @if (
                                                    ($form->period == 'daily' && $isDayPassed) ||
                                                        ($form->period == 'weekly' && $isWeekPassed) ||
                                                        ($form->period == 'monthly' && $isMonthPassed) ||
                                                        ($form->period == 'yearly' && $isYearPassed) ||
                                                        auth()->user()->masterRole->name == 'superuser')
                                                    {{-- @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin' || auth()->user()->masterRole->name == 'user') --}}
                                                    <a class="btn btn-primary"
                                                        href="{{ route('monitorings.detail', $form->id) }}"><i
                                                            class="fa fa-eye" aria-hidden="true"></i></a>
                                                    {{-- @endif --}}
                                                @endif
                                                @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                                                    @if ($form->status != 'postponed')
                                                        <a href="#" class="btn btn-warning"
                                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to postpone this movement?')) { document.getElementById('postpone-monitoring-{{ $form->id }}').submit(); }"><i
                                                                class="fa fa-ban" aria-hidden="true"></i></i></a>
                                                    @endif
                                                @endif

                                                {{-- <a class="btn btn-warning" href="{{ route('vendors.edit', $vendor->id) }}">edit</a> --}}
                                                @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                                                    @if ($form->status != 'cancelled')
                                                        <a href="#" class="btn btn-danger"
                                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to cancel this movement?')) { document.getElementById('cancel-monitoring-{{ $form->id }}').submit(); }"><i
                                                                class="fa fa-trash" aria-hidden="true"></i></a>
                                                    @endif
                                                @endif


                                                <form id="complete-monitoring-{{ $form->id }}"
                                                    action="{{ route('monitorings.complete', $form->id) }}"
                                                    method="POST" style="display: none;">
                                                    <input name="status" type="text" value="completed">
                                                    @csrf
                                                    @method('PUT')
                                                </form>

                                                <form id="postpone-monitoring-{{ $form->id }}"
                                                    action="{{ route('monitorings.postpone', $form->id) }}"
                                                    method="POST" style="display: none;">
                                                    <input name="status" type="text" value="postponed">
                                                    @csrf
                                                    @method('PUT')
                                                </form>

                                                <form id="process-monitoring-{{ $form->id }}"
                                                    action="{{ route('monitorings.process', $form->id) }}"
                                                    method="POST" style="display: none;">
                                                    <input name="status" type="text" value="in_progress">
                                                    @csrf
                                                    @method('PUT')
                                                </form>

                                                <form id="cancel-monitoring-{{ $form->id }}"
                                                    action="{{ route('monitorings.cancel', $form->id) }}"
                                                    method="POST" style="display: none;">
                                                    <input name="status" type="text" value="cancelled">
                                                    @csrf
                                                    @method('PUT')
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('#item_search, #department_search').on('change', function() {
                var itemFilter = $('#item_search').val();
                var departmentFilter = $('#department_search').val();

                $.ajax({
                    url: "{{ route('monitorings.filter') }}", // Rute untuk filter
                    method: "GET",
                    data: {
                        item_id: itemFilter,
                        department_id: departmentFilter
                    },
                    success: function(response) {
                        console.log(response); // Lihat struktur respon di konsol

                        $('#datatablesSimple tbody').empty(); // Kosongkan tabel

                        var tableBody = $('#datatablesSimple').children('tbody');

                        if (response.monitorings && response.monitorings.length > 0) {
                            $.each(response.monitorings, function(index, monitoring) {
                                var actionButtons = '';

                                // Ambil tanggal transaksi dan tanggal saat ini
                                var transactionDate = new Date(monitoring
                                    .transaction_date);
                                var currentDate = new Date();

                                // Hitung selisih hari
                                var diffTime = Math.abs(currentDate - transactionDate);
                                var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 *
                                    24));

                                // Kondisi untuk menampilkan action berdasarkan periode
                                var periodMap = {
                                    'daily': 1,
                                    'weekly': 7,
                                    'monthly': 30,
                                    'yearly': 365
                                };
                                var periodDays = periodMap[monitoring.period
                                    .toLowerCase()] || 0;

                                // Tampilkan tombol action jika sudah memenuhi tanggal dan periode

                                @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                                    if (monitoring.status != 'in_progress') {
                                        actionButtons +=
                                            '<a href="#" class="btn btn-primary" onclick="event.preventDefault(); if(confirm(\'Are you sure you want to process this movement?\')) { document.getElementById(\'process-monitoring-' +
                                            monitoring.id +
                                            '\').submit(); }"><i class="fa-solid fa-play" aria-hidden="true"></i></a>';
                                    }
                                    if (monitoring.status != 'completed') {
                                        actionButtons +=
                                            '<a href="#" class="btn btn-success" onclick="event.preventDefault(); if(confirm(\'Are you sure you want to complete this movement?\')) { document.getElementById(\'complete-monitoring-' +
                                            monitoring.id +
                                            '\').submit(); }"><i class="fa fa-check-circle" aria-hidden="true"></i></a>';
                                    }
                                @endif
                                if (diffDays >= periodDays) {
                                    @if (auth()->user()->masterRole->name == 'superuser' ||
                                            auth()->user()->masterRole->name == 'admin' ||
                                            auth()->user()->masterRole->name == 'user')
                                        actionButtons +=
                                            '<a class="btn btn-primary" href="{{ route('monitorings.detail', '') }}/' +
                                            monitoring.id +
                                            '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                                    @endif
                                }
                                @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                                    if (monitoring.status != 'postponed') {
                                        actionButtons +=
                                            '<a href="#" class="btn btn-warning" onclick="event.preventDefault(); if(confirm(\'Are you sure you want to postpone this movement?\')) { document.getElementById(\'postpone-monitoring-' +
                                            monitoring.id +
                                            '\').submit(); }"><i class="fa fa-ban" aria-hidden="true"></i></a>';
                                    }
                                    if (monitoring.status != 'cancelled') {
                                        actionButtons +=
                                            '<a href="#" class="btn btn-danger" onclick="event.preventDefault(); if(confirm(\'Are you sure you want to cancel this movement?\')) { document.getElementById(\'cancel-monitoring-' +
                                            monitoring.id +
                                            '\').submit(); }"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                                    }
                                @endif


                                var row = '<tr>' +
                                    '<td>' + monitoring.id + '</td>' +
                                    '<td>' + monitoring.transaction_date + '</td>' +
                                    '<td>' + (monitoring.master_item ? monitoring
                                        .master_item.name : '') + '</td>' +
                                    '<td>' + (monitoring.master_department ? monitoring
                                        .master_department.name : '') + '</td>' +
                                    '<td>' + (monitoring.user ? monitoring.user.name :
                                        '') + '</td>' +
                                    '<td>' + monitoring.code + '</td>' +
                                    '<td>' + monitoring.period + '</td>' +
                                    '<td>' + monitoring.status + '</td>' +
                                    '<td>' + monitoring.description + '</td>' +
                                    '<td>' + monitoring.quantity + '</td>' +
                                    '<td>' + monitoring.cost + '</td>' +
                                    '<td>' + '<img src="{{ asset('storage/') }}/' +
                                    monitoring.photo_proof +
                                    '" alt="Proof" style="max-width: 100px; max-height: 100px;" />' +
                                    '</td>' +
                                    '<td>' + actionButtons + '</td>' +
                                    '</tr>';
                                tableBody.append(row);
                            });
                        } else {
                            var noDataRow = '<tr><td colspan="12">No data available</td></tr>';
                            tableBody.append(noDataRow);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            });
        });
    </script>
</body>

</html>
