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
                    <h1 class="mt-4">Transaction Movement Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transaction Movement Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('procurements.create') }}">Tambah Mutasi Barang</a>
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
                                        <th scope="col">ID</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Kode</th>
                                        <th scope="col">Pengusul</th>
                                        <th scope="col">Dari</th>
                                        <th scope="col">Ke</th>
                                        <th scope="col">Tujuan</th>
                                        <th scope="col">Status Barang</th>
                                        <th scope="col">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $movementHeader->id }}</td>
                                        <td>{{ $movementHeader->transaction_date }}</td>
                                        <td>
                                            {{-- {{ $movementHeader->status }} --}}
                                            @if ($movementHeader->status == 'approved')
                                                <button class="btn btn-success btn-sm">Disetujui</button>
                                            @elseif ($movementHeader->status == 'rejected')
                                                <button class="btn btn-warning btn-sm">Ditolak</button>
                                            @elseif ($movementHeader->status == 'in_progress')
                                                <button class="btn btn-primary btn-sm">Proses</button>
                                            @endif
                                        </td>
                                        <td>{{ $movementHeader->code }}</td>
                                        <td>{{ $movementHeader->user->name }}</td>
                                        <td>{{ $movementHeader->masterDepartmentFrom->name }}</td>
                                        <td>{{ $movementHeader->masterDepartmentTo->name }}</td>
                                        <td>{{ $movementHeader->purpose }}</td>
                                        <td>{{ $movementHeader->masterStatus->description }}</td>
                                        <td>{{ $movementHeader->description }}</td>
                                        <td>

                                        </td>
                                    </tr>


                                </tbody>

                            </table>
                            <!-- end header -->
                            @if (auth()->user()->masterRole->name == 'superuser')
                                @if ($movementHeader->status != 'approved')
                                    <a href="#" class="btn btn-success"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to approve this movement?')) { document.getElementById('approve-movement-{{ $movementHeader->id }}').submit(); }"><i
                                            class="fa fa-check-circle" aria-hidden="true"></i></a>
                                @endif
                            @endif

                            @if (auth()->user()->masterRole->name == 'superuser')
                                @if ($movementHeader->status != 'rejected')
                                    <a href="#" class="btn btn-warning"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to reject this movement?')) { document.getElementById('reject-movement-{{ $movementHeader->id }}').submit(); }"><i
                                            class="fa fa-ban" aria-hidden="true"></i></a>
                                @endif

                            @endif

                            {{-- <a class="btn btn-warning" href="{{ route('vendors.edit', $vendor->id) }}">edit</a> --}}
                            @if (auth()->user()->masterRole->name == 'superuser')
                                <a href="#" class="btn btn-danger"
                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this movement?')) { document.getElementById('delete-movement-{{ $movementHeader->id }}').submit(); }"><i
                                        class="fa fa-trash" aria-hidden="true"></i></a>
                            @endif


                            <form id="delete-movement-{{ $movementHeader->id }}"
                                action="{{ route('movements.destroy', $movementHeader->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>

                            <form id="approve-movement-{{ $movementHeader->id }}"
                                action="{{ route('movements.approve', $movementHeader->id) }}" method="POST"
                                style="display: none;">
                                <input name="status" type="text" value="approved">
                                @csrf
                                @method('PUT')
                            </form>

                            <form id="reject-movement-{{ $movementHeader->id }}"
                                action="{{ route('movements.reject', $movementHeader->id) }}" method="POST"
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
                                        <th>Stok</th>
                                        <th>Kuantitas/Jumlah</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Item</th>
                                        <th>Stok</th>
                                        <th>Kuantitas/Jumlah</th>

                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($movementDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->id }}</td>
                                            <td>{{ $detail->masterItem->name }}</td>
                                            <td>{{ $detail->stock }}</td>
                                            <td>{{ $detail->quantity }}</td>
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
