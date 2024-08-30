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
                    <h1 class="mt-4">Transaction Item Depreciation Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transaction Item Depreciation Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('depreciations.create') }}">Tambah Penyusutan Barang</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan penyusutan barang, apabila ada
                            masalah silakan hubungi kewenangan diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Penyusutan Barang
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>

                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Barcode</th>
                                        <th>Item</th>
                                        <th>Departemen</th>
                                        <th>User</th>
                                        <th>Harga</th>
                                        <th>Umur Manfaat</th>
                                        <th>Nilai Residu</th>
                                        <th>Nilai Penyusutan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Barcode</th>
                                        <th>Item</th>
                                        <th>Departemen</th>
                                        <th>User</th>
                                        <th>Harga</th>
                                        <th>Umur Manfaat</th>
                                        <th>Nilai Residu</th>
                                        <th>Nilai Penyusutan</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($depreciations as $depreciation)
                                        <tr>
                                            <td>{{ $depreciation->id }}</td>
                                            <td>{{ $depreciation->procurement_date }}</td>
                                            <td>{{ $depreciation->masterItem->barcode }}</td>
                                            <td>{{ $depreciation->masterItem->name }}</td>
                                            <td>{{ $depreciation->masterDepartment->name }}</td>
                                            <td>{{ $depreciation->user->name }}</td>
                                            <td>{{ $depreciation->price }}</td>
                                            <td>{{ $depreciation->useful_life }}</td>
                                            <td>{{ $depreciation->residual_value }}</td>
                                            <td>{{ $depreciation->depreciation_value }}</td>
                                            <td>
                                                {{-- <a class="btn btn-warning" href="{{ route('vendors.edit', $vendor->id) }}">edit</a> --}}
                                                @if (auth()->user()->masterRole->name == 'superuser')
                                                    <a href="#" class="btn btn-danger"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this item depreciation?')) { document.getElementById('delete-depreciation-{{ $depreciation->id }}').submit(); }"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></a>
                                                @endif


                                                <form id="delete-depreciation-{{ $depreciation->id }}"
                                                    action="{{ route('depreciations.destroy', $depreciation->id) }}"
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
