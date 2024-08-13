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
                    <h1 class="mt-4">Transaction Procurement Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transaction Procurement Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('procurements.create') }}">Tambah Pengadaan</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan pengadaan, apabila ada
                            masalah silakan hubungi kewenangan diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Pengadaan
                        </div>
                        <div class="card-body">
                            <!-- procurement header -->
                            <table class="table" id="datatables">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Kode</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $procurementHeader->id }}</td>
                                        <td>{{ $procurementHeader->transaction_date }}</td>
                                        <td>
                                            {{-- {{ $procurementHeader->status }} --}}
                                            @if ($procurementHeader->status == 'approved')
                                                <button class="btn btn-success btn-sm">Disetujui</button>
                                            @elseif ($procurementHeader->status == 'rejected')
                                                <button class="btn btn-warning btn-sm">Ditolak</button>
                                            @elseif ($procurementHeader->status == 'in_progress')
                                                <button class="btn btn-primary btn-sm">Proses</button>
                                            @endif
                                        </td>
                                        <td>{{ $procurementHeader->code }}</td>
                                        <td>{{ $procurementHeader->description }}</td>
                                        <td>{{ number_format($procurementHeader->total, 2, ',', '.') }}</td>

                                        <td>

                                        </td>
                                    </tr>


                                </tbody>

                            </table>
                            <!-- end header -->
                            @if (auth()->user()->masterRole->name == 'superuser')
                                @if ($procurementHeader->status != 'approved')
                                    <a href="#" class="btn btn-success"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to approve this procurement?')) { document.getElementById('approve-procurement-{{ $procurementHeader->id }}').submit(); }"><i
                                            class="fa fa-check-circle" aria-hidden="true"></i></a>
                                @endif
                            @endif

                            @if (auth()->user()->masterRole->name == 'superuser')
                                @if ($procurementHeader->status != 'rejected')
                                    <a href="#" class="btn btn-warning"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to reject this procurement?')) { document.getElementById('reject-procurement-{{ $procurementHeader->id }}').submit(); }"><i
                                            class="fa fa-ban" aria-hidden="true"></i></a>
                                @endif

                            @endif

                            {{-- <a class="btn btn-warning" href="{{ route('vendors.edit', $vendor->id) }}">edit</a> --}}
                            @if (auth()->user()->masterRole->name == 'superuser')
                                <a href="#" class="btn btn-danger"
                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this procurement?')) { document.getElementById('delete-procurement-{{ $procurementHeader->id }}').submit(); }"><i
                                        class="fa fa-trash" aria-hidden="true"></i></a>
                            @endif


                            <form id="delete-procurement-{{ $procurementHeader->id }}"
                                action="{{ route('procurements.destroy', $procurementHeader->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <form id="approve-procurement-{{ $procurementHeader->id }}"
                                action="{{ route('procurements.approve', $procurementHeader->id) }}" method="POST"
                                style="display: none;">
                                <input name="status" type="text" value="approved">
                                @csrf
                                @method('PUT')
                            </form>

                            <form id="reject-procurement-{{ $procurementHeader->id }}"
                                action="{{ route('procurements.reject', $procurementHeader->id) }}" method="POST"
                                style="display: none;">
                                <input name="status" type="text" value="rejected">
                                @csrf
                                @method('PUT')
                            </form>
                            <!-- procurement detail -->
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Item</th>
                                        <th>Kuantitas/Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Departemen</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama Item</th>
                                        <th>Kuantitas/Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Departemen</th>

                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($procurementDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->id }}</td>
                                            <td>{{ $detail->masterItem->name }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>{{ number_format($detail->price, 2, ',', '.') }}</td>
                                            <td>{{ number_format($detail->subtotal, 2, ',', '.') }}</td>
                                            <td>{{ $detail->masterDepartment->name }}</td>

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
