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
                    <h1 class="mt-4">Master Vendor Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Master Vendor Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('vendors.create') }}">Tambah Vendor</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan master vendor dan merupakan kewenangan admin, apabila ada
                            masalah silakan hubungi kewenangan
                            diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Master Vendor
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Nomor Kantor</th>
                                        <th>Pemilik</th>
                                        <th>Nomor Pemilik</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Nomor Kantor</th>
                                        <th>Pemilik</th>
                                        <th>Nomor Pemilik</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($vendors as $vendor)
                                        <tr>
                                            <td>{{ $vendor->id }}</td>
                                            <td>{{ $vendor->name }}</td>
                                            <td>{{ $vendor->address }}</td>
                                            <td>{{ $vendor->office_number }}</td>
                                            <td>{{ $vendor->owner }}</td>
                                            <td>{{ $vendor->owner_number }}</td>

                                            <td>
                                                <a class="btn btn-primary"
                                                    href="{{ route('vendor_items.index', $vendor->id) }}">Lihat Data</a>
                                                <a class="btn btn-warning"
                                                    href="{{ route('vendors.edit', $vendor->id) }}">edit</a>
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
