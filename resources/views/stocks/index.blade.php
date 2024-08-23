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
                    <h1 class="mt-4">Transaction Stock Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transaction Stock Tables</li>
                    </ol>
                    {{-- <a class="btn btn-success" href="{{ route('movements.create') }}">Tambah Mutasi Barang</a> --}}
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan stok(inventory) barang, apabila ada
                            masalah silakan hubungi kewenangan diatasnya.
                        </div>
                    </div>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Kartu Stok
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Kartu Stok</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('stocks.generatePDF') }}">
                                    <div class="modal-body">
                                        <h2>Kartu Stok</h2>
                                        <label for="item_id_stock">Nama Item</label>
                                        <select name="item_id_stock" id="item_id_stock" class="form-control item-id"
                                            required>
                                            <option value="">Pilih Item</option>
                                            @foreach ($masterItems as $item)
                                                <option value="{{ $item->id }}" data-nama="{{ $item->name }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="department_id_stock">Nama Departemen</label>
                                        <select name="department_id_stock" id="department_id_stock"
                                            class="form-control item-id" required>
                                            <option value="">Pilih Departemen</option>
                                            @foreach ($masterDepartments as $department)
                                                <option value="{{ $department->id }}"
                                                    data-nama="{{ $department->name }}">
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="start_date" class="form-control">Tanggal Awal</label>
                                        <input type="date" id="start_date" name="start_date" value="" required>
                                        <label for="end_date" class="form-control">Tanggal AKhir</label>
                                        <input type="date" id="end_date" name="end_date" value="" required>




                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div>
                        <select name="item" id="item_search" class="form-control item-id mb-3">
                            <option value="">Pilih Item</option>
                            @foreach ($masterItems as $item)
                                <option value="{{ $item->id }}" data-nama="{{ $item->name }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="department" id="department_search" class="form-control department-id mb-3">
                            <option value="">Pilih Departemen</option>
                            @foreach ($masterDepartments as $department)
                                <option value="{{ $department->id }}" data-nama="{{ $department->name }}">
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Stok Barang
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Item</th>
                                        <th>Departemen</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Item</th>
                                        <th>Departemen</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </tfoot>
                                <tbody id="inventory-table-body">
                                    @foreach ($inventories as $inventory)
                                        <tr>
                                            <td>{{ $inventory->id }}</td>
                                            <td>{{ $inventory->masterItem->name }}</td>
                                            <td>{{ $inventory->masterDepartment->name }}</td>
                                            <td>{{ $inventory->quantity }}</td>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('#item_search, #department_search').on('change', function() {
                var itemFilter = $('#item_search').val();
                var departmentFilter = $('#department_search').val();

                $.ajax({
                    url: "{{ route('stocks.filter') }}", // Ensure this route returns the correct JSON
                    method: "GET",
                    data: {
                        item_id: itemFilter,
                        department_id: departmentFilter
                    },
                    success: function(response) {
                        console.log(response); // Check the structure of the response
                        //var tableBody = $('#inventory-table-body');
                        //tableBody.empty(); // Clear existing rows
                        $('#datatablesSimple tbody').empty();
                        var tableBody = $('#datatablesSimple').children('tbody')

                        if (response.inventories && response.inventories.length > 0) {
                            $.each(response.inventories, function(index, inventory) {
                                var row = '<tr>' +
                                    '<td>' + inventory.id + '</td>' +
                                    '<td>' + inventory.master_item.name + '</td>' +
                                    '<td>' + inventory.master_department.name +
                                    '</td>' +
                                    '<td>' + inventory.quantity + '</td>' +
                                    '</tr>';
                                tableBody.append(row);
                            });
                        } else {
                            var noDataRow = '<tr><td colspan="4">No data available</td></tr>';
                            tableBody.append(noDataRow);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            });


        }); // akhir
    </script>
</body>

</html>
