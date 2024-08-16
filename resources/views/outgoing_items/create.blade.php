@include('templates.head_create_choices')

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
                    <h1>Form Input Barang Keluar</h1>
                    {{-- <button id="addRow" class="btn btn-success">Add Row</button> --}}

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Item/Barang</th>
                                <th>Departemen</th>
                                <th>User</th>
                                <th>Jumlah</th>
                                <th>Status_Barang</th>
                                <th>Keterangan</th>
                                <th>Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="date" id="transaction_date" required></td>
                                <td><input type="text" id="code" readonly required></td>
                                <td>
                                    <select id="item_id" class="form-control item-id mb-3" required>
                                        <option value="">Pilih Item</option>
                                        @foreach ($masterItems as $item)
                                            <option value="{{ $item->id }}" data-nama="{{ $item->name }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select id="department_id" class="form-control item-id mb-3" required>
                                        <option value="">Pilih Departemen</option>
                                        @foreach ($masterDepartments as $department)
                                            <option value="{{ $department->id }}" data-nama="{{ $department->name }}">
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input id="user_id" type="hidden" value="{{ auth()->user()->id }}" readonly
                                        required>
                                    {{ auth()->user()->name }}
                                </td>
                                <td><input type="text" id="quantity" required></td>
                                <td>
                                    <select id="status_id" class="form-control item-id mb-3">
                                        <option value="">Pilih Status</option>
                                        @foreach ($masterItemStatuses as $status)
                                            <option value="{{ $status->id }}" data-nama="{{ $status->description }}">
                                                {{ $status->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" id="description"></td>
                                <td><input type="text" id="purpose"></td>
                            </tr>
                            <tr>
                                <td><button class="btn btn-success" id="addRow">Add Row</button></td>
                                <td><input type="hidden" id="maxId" value="{{ $maxId }}" readonly></td>
                            </tr>
                        </tbody>
                    </table>

                    <form id="dataForm" action="{{ route('outgoing_items.store') }}" method="POST">
                        @csrf
                        <table id="datatable" class="display table">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Item</th>
                                    <th>Departemen</th>
                                    <th>User</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Tujuan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Rows will be added here -->
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </main>

            @include('templates.footer')
        </div>
        <!-- end layout content-->
    </div>
    <!-- end layout sidenav -->
    @include('templates.script')

    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#transaction_date').on('change', function() {

                var maxId = $('#maxId').val();

                var maxCodeNumber = 0;



                // Reset the #code input field before generating a new one
                $('#code').val('');
                // Convert maxId to an integer, or default to 0 if it's not a valid number
                maxId = parseInt(maxId, 10) || 0;

                var rowCount = document.getElementById('datatable').tBodies[0].rows.length;
                rowCount = parseInt(rowCount, 10) || 0;

                maxCodeNumber = parseInt(maxId) + parseInt(rowCount);

                var newCodeNumber = (maxCodeNumber + 1).toString().padStart(4, '0');
                var selectedDate = $('#transaction_date').val().replace(/-/g, '');
                var newCode = `OUT-${selectedDate}${newCodeNumber}`;

                $('#code').val(newCode);
            });


            $('#addRow').click(function() {
                var transactionDate = $('#transaction_date').val();
                var code = $('#code').val();
                var itemId = $('#item_id').val();
                var itemName = $('#item_id').find(':selected').data('nama');
                var departmentId = $('#department_id').val();
                var departmentName = $('#department_id').find(':selected').data('nama');
                var userId = $('#user_id').val();
                var userName = "{{ auth()->user()->name }}";
                var quantity = $('#quantity').val();
                var statusId = $('#status_id').val();
                var statusName = $('#status_id').find(':selected').data('nama');
                var description = $('#description').val();
                var purpose = $('#purpose').val();

                if (itemId && itemName && departmentId && departmentName) {
                    var isDuplicate = false;
                    $('#datatable tbody tr').each(function() {
                        var existingItemId = $(this).find('input[name="item_id[]"]').val();
                        var existingDepartmentId = $(this).find('input[name="department_id[]"]')
                            .val();
                        if (existingItemId === itemId && existingDepartmentId ===
                            departmentId) {
                            isDuplicate = true;
                            return false;
                        }
                    });

                    if (!isDuplicate) {
                        var row = `<tr>
                                        <input type="hidden" name="transaction_date[]" value="${transactionDate}" readonly>
                                        <td><input type="text" name="code[]" value="${code}" class="form-control" readonly></td>
                                        <td><input type="text" name="item_name[]" value="${itemName}" class="form-control" readonly></td>
                                        <td><input type="text" name="department_name[]" value="${departmentName}" class="form-control" readonly></td>
                                        <td><input type="text" name="user_name[]" value="${userName}" class="form-control" readonly></td>
                                        <td><input type="text" name="quantity[]" value="${quantity}" class="form-control quantity" readonly></td>
                                        <td><input type="text" name="item_status_name[]" value="${statusName}" class="form-control" readonly></td>
                                        <td><input type="text" name="description[]" value="${description}" class="form-control" readonly></td>
                                        <td><input type="text" name="purpose[]" value="${purpose}" class="form-control" readonly></td>
                                        <td><button type="button" class="btn btn-danger delete-row">Delete</button></td>
                                        <input type="hidden" name="item_id[]" value="${itemId}">
                                        <input type="hidden" name="department_id[]" value="${departmentId}">
                                        <input type="hidden" name="user_id[]" value="${userId}">
                                        <input type="hidden" name="status_id[]" value="${statusId}">
                                    </tr>`;
                        $('#datatable tbody').append(row);
                    } else {
                        alert('Item ini sudah ditambahkan.');
                    }

                    $('#transaction_date').val('');
                    $('#code').val('');
                    $('#item_id').val('');
                    $('#department_id').val('');
                    $('#quantity').val('');
                    $('#status_id').val('');
                    $('#description').val('');
                    $('#purpose').val('');
                }
            });

            $('#datatable').on('click', '.delete-row', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
</body>

</html>
