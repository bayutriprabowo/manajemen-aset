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
                    <h1 class="mt-4">Master Procurement Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Master Procurement Tables</li>
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
                            <table id="datatablesSimple">
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
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Kode</th>
                                        <th>Keterangan</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($procurementHeader as $header)
                                        <tr>
                                            <td>{{ $header->id }}</td>
                                            <td>{{ $header->transaction_date }}</td>
                                            <td>{{ $header->status }}</td>
                                            <td>{{ $header->code }}</td>
                                            <td>{{ $header->description }}</td>
                                            <td>{{ $header->total }}</td>

                                            <td>
                                                <a class="btn btn-primary"
                                                    href="{{ route('procurement_details.index', $header->id) }}">Lihat
                                                    Detail Pengadaan</a>
                                                {{-- <a class="btn btn-warning" href="{{ route('vendors.edit', $vendor->id) }}">edit</a> --}}
                                                <a href="#" class="btn btn-danger"
                                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this vendor?')) { document.getElementById('delete-vendor-{{ $vendor->id }}').submit(); }">Delete</a>

                                                <form id="delete-vendor-{{ $vendor->id }}"
                                                    action="{{ route('vendors.destroy', $vendor->id) }}" method="POST"
                                                    style="display: none;">
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
