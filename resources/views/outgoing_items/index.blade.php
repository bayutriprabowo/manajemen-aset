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
                    <h1 class="mt-4">Transaction Outgoing Item Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transaction Outgoing item Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('outgoing_items.create') }}">Tambah Barang Keluar</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan Barang Keluar, apabila ada
                            masalah silakan hubungi kewenangan diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Barang Keluar
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
                                        <th>Item</th>
                                        <th>Departemen</th>
                                        <th>User</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal</th>
                                        <th>Status Barang</th>
                                        <th>Keterangan</th>
                                        <th>Tujuan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
                                        <th>Item</th>
                                        <th>Departemen</th>
                                        <th>User</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal</th>
                                        <th>Status Barang</th>
                                        <th>Keterangan</th>
                                        <th>Tujuan</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($outgoingItems as $outgoing)
                                        <tr>
                                            <td>{{ $outgoing->id }}</td>
                                            <td>{{ $outgoing->code }}</td>
                                            <td>{{ $outgoing->masterItem->name }}</td>
                                            <td>{{ $outgoing->masterDepartment->name }}</td>
                                            <td>{{ $outgoing->user->name }}</td>
                                            <td>{{ $outgoing->quantity }}</td>
                                            <td>{{ $outgoing->transaction_date }}</td>
                                            <td>{{ $outgoing->masterItemStatus->description }}</td>
                                            <td>{{ $outgoing->description }}</td>
                                            <td>{{ $outgoing->purpose }}</td>
                                            <td>
                                                {{-- <a class="btn btn-warning" href="{{ route('vendors.edit', $vendor->id) }}">edit</a> --}}
                                                @if (auth()->user()->masterRole->name == 'superuser')
                                                    <a href="#" class="btn btn-danger"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this outgoing item?')) { document.getElementById('delete-outgoing-item-{{ $outgoing->id }}').submit(); }"><i
                                                            class="fa fa-undo" aria-hidden="true"></i></a>
                                                @endif


                                                <form id="delete-outgoing-item-{{ $outgoing->id }}"
                                                    action="{{ route('outgoing_items.destroy', $outgoing->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
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
</body>

</html>
