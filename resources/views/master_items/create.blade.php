@include('templates.head_create')

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

                    <!-- isi table -->
                    <h1>Form Input Item</h1>
                    <button id="addRow" class="btn btn-success">Add Row</button>
                    <form id="dataForm" action="{{ route('items.store') }}" method="POST">
                        @csrf
                        <table id="datatable" class="display">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Name</th>
                                    <th>Harga</th>
                                    <th>Tipe Item/Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Rows will be added here -->
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                    <!-- isi table -->
                </div>
            </main>






            @include('templates.footer')
        </div>
        <!-- end layout content-->
    </div>
    <!-- end layout sidenav -->
    @include('templates.script')

    {{-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> --}}
    <script src="cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize DataTable
            try {
                var table = new DataTable('#datatable');
                console.log('DataTable initialized successfully');
            } catch (error) {
                console.error('Error initializing DataTable:', error);
            }

            // Add row functionality
            document.getElementById('addRow').addEventListener('click', function() {
                var tbody = document.querySelector('#datatable tbody');
                if (!tbody) {
                    console.error('Table body not found');
                    return;
                }

                var optionsItemType = `<option value="">Pilih Tipe/Jenis</option>
        @foreach ($masterItemTypes as $type)
            <option value="{{ $type->id }}">{{ $type->name }}</option>
        @endforeach`;

                var newRow = document.createElement('tr');
                newRow.innerHTML = `
            <td><input type="text" name="barcode[]" class="form-control"></td>
            <td><input type="text" name="name[]" class="form-control" required></td>
            <td><input type="text" name="price[]" class="form-control" required></td>
            <td class="col-3">
                <select name="type_id[]" class="form-control type-select" required>
                    ${optionsItemType}
                </select>
            </td>
            <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
        `;

                tbody.appendChild(newRow);

                // Initialize Choices.js for the new select element
                new Choices(newRow.querySelector('.type-select'));

                console.log('New row added');
            });

            // Remove row functionality
            document.querySelector('#datatable tbody').addEventListener('click', function(e) {
                if (e.target.classList.contains('removeRow')) {
                    var row = e.target.closest('tr');
                    if (row) {
                        row.remove();
                        console.log('Row removed');
                    } else {
                        console.error('Row not found');
                    }
                }
            });
        });
    </script>
</body>

</html>
