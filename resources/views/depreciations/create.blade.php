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
                    <h1>Form Penyusutan Barang</h1>
                    {{-- <button id="addRow" class="btn btn-success">Add Row</button> --}}

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal Pengadaan</th>
                                <th>Item</th>
                                <th>Departemen</th>
                                <th>User</th>
                                <th>Harga</th>
                                <th>Umur Manfaat</th>
                                <th>Nilai Residu</th>
                                <th>Nilai Penyusutan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="date" id="procurement_date" required></td>

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
                                <td><input type="text" id="price" required></td>

                                <td><input type="text" id="useful_life"></td>
                                <td><input type="text" id="residual_value"></td>
                                <td><input type="text" id="depreciation_value"></td>
                            </tr>
                            <tr>
                                <td><button class="btn btn-success" id="addRow">Add Row</button></td>
                                <td><input type="hidden" id="maxId" value="{{ $maxId }}" readonly></td>
                            </tr>
                        </tbody>
                    </table>

                    <form id="dataForm" action="{{ route('depreciations.store') }}" method="POST">
                        @csrf
                        <table id="datatable" class="display table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
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
            $('#procurement_date, #item_id, #department_id').change(function() {
                var procurementDate = $('#procurement_date').val();
                var itemId = $('#item_id').val();
                var departmentId = $('#department_id').val();

                if (procurementDate && itemId && departmentId) {
                    $.ajax({
                        url: '{{ route('get_price') }}',
                        type: 'GET',
                        data: {
                            procurement_date: procurementDate,
                            item_id: itemId,
                            department_id: departmentId
                        },
                        success: function(response) {
                            if (response.price) {
                                $('#price').val(response.price);
                                calculateDepreciation(); // Hitung ulang penyusutan
                            } else {
                                $('#price').val('');
                            }
                        },
                        error: function(xhr) {
                            console.error('Error fetching price:', xhr);
                        }
                    });
                } else {
                    $('#price').val('');
                }
            });

            function calculateDepreciation() {
                var price = parseFloat($('#price').val()) || 0;
                var usefulLife = parseFloat($('#useful_life').val()) || 0;
                var residualValue = parseFloat($('#residual_value').val()) || 0;

                if (usefulLife > 0) {
                    var depreciationValue = (price - residualValue) / usefulLife;
                    $('#depreciation_value').val(depreciationValue.toFixed(2));
                } else {
                    $('#depreciation_value').val('');
                }
            }

            $('#price, #useful_life, #residual_value').on('input', calculateDepreciation);

            $('#addRow').click(function() {
                var procurementDate = $('#procurement_date').val();
                var itemId = $('#item_id').val();
                var itemName = $('#item_id').find(':selected').data('nama');
                var departmentId = $('#department_id').val();
                var departmentName = $('#department_id').find(':selected').data('nama');
                var userId = $('#user_id').val();
                var userName = "{{ auth()->user()->name }}";
                var price = $('#price').val();
                var usefulLife = $('#useful_life').val();
                var residualValue = $('#residual_value').val();
                var depreciationValue = $('#depreciation_value').val();

                if (itemId && itemName && departmentId && departmentName) {
                    var isDuplicate = false;
                    $('#datatable tbody tr').each(function() {
                        var existingItemId = $(this).find('input[name="item_id[]"]').val();
                        var existingDepartmentId = $(this).find('input[name="department_id[]"]')
                            .val();
                        var existingProcurementDate = $(this).find(
                            'input[name="procurement_date[]"]').val();
                        if (existingItemId === itemId && existingDepartmentId === departmentId &&
                            existingProcurementDate == procurementDate) {
                            isDuplicate = true;
                            return false;
                        }
                    });

                    if (!isDuplicate) {
                        var row = `<tr>
                    <td><input type="date" name="procurement_date[]" value="${procurementDate}" readonly></td>
                    <td><input type="text" name="item_name[]" value="${itemName}" class="form-control" readonly></td>
                    <td><input type="text" name="department_name[]" value="${departmentName}" class="form-control" readonly></td>
                    <td><input type="text" name="user_name[]" value="${userName}" class="form-control" readonly></td>
                    <td><input type="text" name="price[]" value="${price}" class="form-control quantity" readonly></td>
                    <td><input type="text" name="useful_life[]" value="${usefulLife}" class="form-control" readonly></td>
                    <td><input type="text" name="residual_value[]" value="${residualValue}" class="form-control" readonly></td>
                    <td><input type="text" name="depreciation_value[]" value="${depreciationValue}" class="form-control" readonly></td>
                    <td><button type="button" class="btn btn-danger delete-row">Delete</button></td>
                    <input type="hidden" name="item_id[]" value="${itemId}">
                    <input type="hidden" name="department_id[]" value="${departmentId}">
                    <input type="hidden" name="user_id[]" value="${userId}">
                </tr>`;
                        $('#datatable tbody').append(row);
                    } else {
                        alert('Item ini sudah ditambahkan.');
                    }

                    // Reset form setelah penambahan baris
                    $('#procurement_date').val('');
                    $('#item_id').val('');
                    $('#department_id').val('');
                    $('#price').val('');
                    $('#useful_life').val('');
                    $('#residual_value').val('');
                    $('#depreciation_value').val('');
                }
            });

            $('#datatable').on('click', '.delete-row', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
</body>

</html>
