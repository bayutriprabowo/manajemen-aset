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
                    <h1>Form Input Mutasi Barang</h1>
                    {{-- <button id="addRow" class="btn btn-success">Add Row</button> --}}




                    <form id="dataForm" action="{{ route('movements.store', $newId) }}" method="POST">
                        @csrf
                        <table id="" class="table">
                            <thead>
                                <tr>

                                    <th>Tanggal</th>
                                    <th>Kode</th>
                                    <th>Departemen Dari</th>
                                    <th>Departemen Ke</th>
                                    <th>Tujuan</th>
                                    <th>Status Barang</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <input type="hidden" name="id_header" id="id_header"
                                        data-header="{{ $newId }}" value="{{ $newId }}" readonly>
                                    <td><input type="date" name="transaction_date" required></td>
                                    <input type="hidden" name="status" value="in_progress" readonly>
                                    <td><input type="text" name="code" value="MOV-{{ $newId }}" readonly>
                                    </td>
                                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}"
                                        readonly>
                                    </td>
                                    <td><select name="department_id_from" id="department_id_from"
                                            class="form-control item-id mb-3" required>
                                            <option value="">Departemen Dari:</option>
                                            @foreach ($masterDepartments as $department)
                                                <option value="{{ $department->id }}"
                                                    data-nama="{{ $department->name }}">
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select></td>
                                    <td><select name="department_id_to" id="department_id_to"
                                            class="form-control item-id mb-3" required>
                                            <option value="">Departemen Ke:</option>
                                            @foreach ($masterDepartments as $department)
                                                <option value="{{ $department->id }}"
                                                    data-nama="{{ $department->name }}">
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select></td>
                                    <td><input type="text" name="purpose"></td>
                                    <td><select name="status_id" id="status_id" class="form-control item-id mb-3"
                                            required>
                                            <option value="">Status:</option>
                                            @foreach ($masterStatuses as $status)
                                                <option value="{{ $status->id }}"
                                                    data-nama="{{ $status->description }}">
                                                    {{ $status->description }}
                                                </option>
                                            @endforeach
                                        </select></td>
                                    <td><input type="text" name="description"></td>


                                </tr>

                            </tbody>
                        </table>

                        <select name="item" id="addRow" class="form-control item-id mb-3">
                            <option value="">Pilih Item</option>
                            @foreach ($masterItems as $item)
                                <option value="{{ $item->id }}" data-nama="{{ $item->name }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>


                        <table id="datatable" class="table display">
                            <thead>
                                <tr>
                                    <th>Nama Item</th>
                                    <th>Stok</th>
                                    <th>Kuantitas/Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Rows will be added here -->
                            </tbody>
                        </table>
                        <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
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
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {

            // Nonaktifkan addRow dan submit secara default
            $('#addRow').prop('disabled', true);
            $('#submitBtn').prop('disabled', true);

            // Event listener untuk department_id_from dan department_id_to
            $('#department_id_from, #department_id_to').on('change', function() {
                var departmentIdFrom = $('#department_id_from').val();
                var departmentIdTo = $('#department_id_to').val();

                // Cek apakah departemen From dan To sama
                if (departmentIdFrom && departmentIdTo && departmentIdFrom === departmentIdTo) {
                    alert('Departemen "Dari" dan "Ke" tidak boleh sama!'); // Tampilkan alert jika sama
                    $('#submitBtn').prop('disabled', true); // Nonaktifkan tombol submit
                } else if (departmentIdFrom) {
                    $('#addRow').prop('disabled', false); // Aktifkan addRow jika department_id_from dipilih
                    checkSubmitButton(); // Periksa apakah tombol submit harus diaktifkan
                } else {
                    $('#addRow').prop('disabled', true); // Nonaktifkan addRow jika tidak ada yang dipilih
                    $('#submitBtn').prop('disabled', true); // Nonaktifkan submit jika tidak valid
                }
            });

            var inventories = @json($inventories);

            $('input[name="transaction_date"]').on('change', function() {
                var selectedDate = $(this).val(); // Ambil tanggal yang dipilih
                var formattedDate = selectedDate.replace(/-/g, ''); // Format tanggal menjadi YYYYMMDD

                var headerId = $('#id_header').val(); // Ambil id_header
                var paddedHeaderId = headerId.padStart(4, '0'); // untuk membuat angka tetap 4 digit
                var newCode = `MOV-${formattedDate}${paddedHeaderId}`; // Gabungkan untuk membuat kode baru

                $('input[name="code"]').val(newCode); // Perbarui nilai input kode
            });

            $('#addRow').on('change', function() {
                var itemId = $(this).val();
                var itemName = $(this).find(':selected').data('nama');
                var headerId = $('#id_header').val();
                var departmentId = $('#department_id_from').val();

                if (itemId && itemName) {
                    // Check for duplicates
                    var isDuplicate = false;
                    $('#datatable tbody tr').each(function() {
                        var existingItemId = $(this).find('input[name="item_id[]"]').val();
                        var existingDepartmentId = $(this).find(
                            'input[name="department_id[]"]').val();
                        if (existingItemId === itemId && existingDepartmentId === departmentId) {
                            isDuplicate = true;
                            return false;
                        }
                    });

                    if (!isDuplicate) {
                        var inventory = inventories.find(function(inv) {
                            return inv.item_id == itemId && inv.department_id == departmentId;
                        });

                        var stockValue = inventory ? inventory.quantity : 0;

                        var row = `<tr>
                                        <td><input type="text" name="item_name[]" value="${itemName}" class="form-control" readonly required></td>
                                        <td><input type="text" name="stock[]" value="${stockValue}" class="form-control quantity" readonly required></td>
                                        <td><input type="number" name="quantity[]" value="" class="form-control quantity" required></td>
                                        <input type="hidden" name="header_id[]" value="${headerId}" readonly>
                                        <input type="hidden" name="department_id[]" value="${departmentId}">
                                        <td><button type="button" class="btn btn-danger delete-row">Delete</button></td>
                                        <input type="hidden" name="item_id[]" value="${itemId}">
                                    </tr>`;

                        $('#datatable tbody').append(row);

                        checkSubmitButton(); // Periksa kembali tombol submit
                    } else {
                        alert('This item is already added.');
                    }

                    // Clear the select box
                    $(this).val('');
                }
            });

            // Cek tombol submit ketika ada perubahan pada kuantitas
            $('#datatable').on('input', '.quantity', function() {
                var stock = parseInt($(this).closest('tr').find('input[name="stock[]"]').val(), 10);
                var quantity = parseInt($(this).val(), 10);

                // Periksa jika kuantitas melebihi stok
                if (quantity > stock) {
                    alert('Quantity melebihi stock!');
                    $(this).val(''); // Clear the input
                }

                checkSubmitButton();
            });

            // Fungsi untuk memeriksa apakah tombol submit harus diaktifkan
            function checkSubmitButton() {
                var isValid = true;

                // Periksa apakah departemen "Dari" dan "Ke" tidak sama
                var departmentIdFrom = $('#department_id_from').val();
                var departmentIdTo = $('#department_id_to').val();
                if (departmentIdFrom && departmentIdTo && departmentIdFrom === departmentIdTo) {
                    isValid = false;
                }

                // Periksa setiap baris
                $('#datatable tbody tr').each(function() {
                    var stock = parseInt($(this).find('input[name="stock[]"]').val(), 10);
                    var quantity = parseInt($(this).find('input[name="quantity[]"]').val(), 10);

                    if (quantity > stock || isNaN(quantity)) {
                        isValid = false;
                    }
                });

                $('#submitBtn').prop('disabled', !isValid); // Aktifkan/nonaktifkan tombol submit
            }

            $('#datatable').on('click', '.delete-row', function() {
                $(this).closest('tr').remove();
                checkSubmitButton();
            });
        });
    </script>
</body>

</html>
