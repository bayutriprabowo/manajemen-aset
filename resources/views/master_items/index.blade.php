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
                    <h1 class="mt-4">Master Item Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Master Item Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('items.create') }}">Tambah Item</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan master item/barang dan merupakan kewenangan admin, apabila ada
                            masalah silakan hubungi kewenangan
                            diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Master Item
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Tipe Item</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Tipe Item</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->masterItemType->name }}</td>
                                            <td><a class="btn btn-warning"
                                                    href="{{ route('departments.edit', $item->id) }}">edit</a>
                                                <a href="#" class="btn btn-danger"
                                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this item?')) { document.getElementById('delete-item-{{ $item->id }}').submit(); }">Delete</a>

                                                <form id="delete-item-{{ $item->id }}"
                                                    action="{{ route('items.destroy', $item->id) }}" method="POST"
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
