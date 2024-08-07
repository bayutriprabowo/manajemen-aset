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
                    <h1 class="mt-4">Master Vendor Item Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Master Vendor Item Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('vendor_items.create', $id) }}">Tambah
                        Vendor Item</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan master item/barang dari vendor dan merupakan kewenangan admin, apabila
                            ada
                            masalah silakan hubungi kewenangan
                            diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Master Vendor Item
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Item</th>
                                        <th>Nama vendor</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Item</th>
                                        <th>Nama vendor</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($vendorItems as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->masterItem->name }}</td>
                                            <td>{{ $vendor->name }}</td>
                                            <td><a class="btn btn-warning"
                                                    href="{{ route('vendor_items.edit', $item->id) }}">edit</a>
                                                <a href="#" class="btn btn-danger"
                                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this item?')) { document.getElementById('delete-vendor-item-{{ $item->id }}').submit(); }">Delete</a>

                                                <form id="delete-vendor-item-{{ $item->id }}"
                                                    action="{{ route('vendor_items.destroy', ['id' => $item->id, 'vendorId' => $id]) }}"
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
