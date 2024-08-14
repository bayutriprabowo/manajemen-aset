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
                    <h1 class="mt-4">Transaction incoming Item Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transaction Incoming item Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('incoming_items.create') }}">Tambah Barang Masuk</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan Barang Masuk, apabila ada
                            masalah silakan hubungi kewenangan diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Barang Masuk
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
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($incomingItems as $incoming)
                                        <tr>
                                            <td>{{ $incoming->id }}</td>
                                            <td>{{ $incoming->code }}</td>
                                            <td>{{ $incoming->masterItem->name }}</td>
                                            <td>{{ $incoming->masterDepartment->name }}</td>
                                            <td>{{ $incoming->user->name }}</td>
                                            <td>{{ $incoming->quantity }}</td>
                                            <td>{{ $incoming->transaction_date }}</td>
                                            <td>{{ $incoming->masterItemStatus->description }}</td>
                                            <td>{{ $incoming->description }}</td>
                                            <td>
                                                {{-- <a class="btn btn-warning" href="{{ route('vendors.edit', $vendor->id) }}">edit</a> --}}
                                                @if (auth()->user()->masterRole->name == 'superuser')
                                                    <a href="#" class="btn btn-danger"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this incoming item?')) { document.getElementById('delete-incoming-item-{{ $incoming->id }}').submit(); }"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></a>
                                                @endif


                                                <form id="delete-incoming-item-{{ $incoming->id }}"
                                                    action="{{ route('incoming_items.destroy', $incoming->id) }}"
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
