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
                            <table id="datatables">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Kode</th>
                                        <th>Keterangan</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $procurementHeader->id }}</td>
                                        <td>{{ $procurementHeader->transaction_date }}</td>
                                        <td>{{ $procurementHeader->status }}</td>
                                        <td>{{ $procurementHeader->code }}</td>
                                        <td>{{ $procurementHeader->description }}</td>
                                        <td>{{ $procurementHeader->total }}</td>

                                        <td>
                                            @if (auth()->user()->masterRole->name == 'superuser')
                                                <a href="#" class="btn btn-success"
                                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to approve this procurement?')) { document.getElementById('approve-procurement-{{ $procurementHeader->id }}').submit(); }">Approve</a>
                                            @endif

                                            @if (auth()->user()->masterRole->name == 'superuser')
                                                <a href="#" class="btn btn-warning"
                                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to reject this procurement?')) { document.getElementById('reject-procurement-{{ $procurementHeader->id }}').submit(); }">Reject</a>
                                            @endif

                                            {{-- <a class="btn btn-warning" href="{{ route('vendors.edit', $vendor->id) }}">edit</a> --}}
                                            @if (auth()->user()->masterRole->name == 'superuser')
                                                <a href="#" class="btn btn-danger"
                                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this procurement?')) { document.getElementById('delete-procurement-{{ $procurementHeader->id }}').submit(); }">Delete</a>
                                            @endif


                                            <form id="delete-procurement-{{ $procurementHeader->id }}"
                                                action="{{ route('procurements.destroy', $procurementHeader->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <form id="approve-procurement-{{ $procurementHeader->id }}"
                                                action="{{ route('procurements.approve', $procurementHeader->id) }}"
                                                method="POST" style="display: none;">
                                                <input name="status" type="text" value="approved">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <form id="reject-procurement-{{ $procurementHeader->id }}"
                                                action="{{ route('procurements.reject', $procurementHeader->id) }}"
                                                method="POST" style="display: none;">
                                                <input name="status" type="text" value="rejectd">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </td>
                                    </tr>
                                    </tr>

                                </tbody>
                            </table>
                            <!-- end header -->
                            <!-- procurement detail -->
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Item</th>
                                        <th>Kuantitas/Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Header ID</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama Item</th>
                                        <th>Kuantitas/Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Header ID</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($procurementDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->id }}</td>
                                            <td>{{ $detail->masterItem->name }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>{{ $detail->price }}</td>
                                            <td>{{ $detail->subtotal }}</td>
                                            <td>{{ $detail->header_id }}</td>
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
