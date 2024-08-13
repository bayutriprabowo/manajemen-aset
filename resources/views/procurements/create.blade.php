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
                    <h1>Form Input Pengadaan</h1>
                    {{-- <button id="addRow" class="btn btn-success">Add Row</button> --}}




                    <form id="dataForm" action="{{ route('procurements.store', $newId) }}" method="POST">
                        @csrf
                        <table id="">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kode</th>
                                    <th>Keterangan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <input type="hidden" name="id_header" id="id_header"
                                        data-header="{{ $newId }}" value="{{ $newId }}" readonly>
                                    <td><input type="date" name="transaction_date" required></td>
                                    <input type="hidden" name="status" value="in_progress" readonly>
                                    <td><input type="text" name="code" value="PRO-{{ $newId }}" readonly>
                                    </td>
                                    <td><input type="text" name="description" required></td>
                                    <td><input type="text" name="total" id="total" value="0.00" readonly>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <select name="item" id="addRow" class="form-control item-id mb-3">
                            <option value="">Pilih Item</option>
                            @foreach ($masterItems as $item)
                                <option value="{{ $item->id }}" data-nama="{{ $item->name }}">{{ $item->name }}
                                </option>
                            @endforeach
                        </select>


                        <table id="datatable" class="display">
                            <thead>
                                <tr>
                                    <th>Nama Item</th>
                                    <th>Kuantitas/Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                    <th>Departemen</th>
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
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {

            $('input[name="transaction_date"]').on('change', function() {
                var selectedDate = $(this).val(); // Ambil tanggal yang dipilih
                var formattedDate = selectedDate.replace(/-/g, ''); // Format tanggal menjadi YYYYMMDD

                var headerId = $('#id_header').val(); // Ambil id_header
                var paddedHeaderId = headerId.padStart(4, '0'); // untuk membuat angka tetap 4 digit
                var newCode = `PRO-${formattedDate}${paddedHeaderId}`; // Gabungkan untuk membuat kode baru

                $('input[name="code"]').val(newCode); // Perbarui nilai input kode
            });


            $('#addRow').change(function() {
                var itemId = $(this).val();
                var itemName = $(this).find(':selected').data('nama');
                var headerId = $('#id_header').val();

                if (itemId && itemName) {
                    // Check for duplicates
                    var isDuplicate = false;
                    $('#datatable tbody tr').each(function() {
                        var existingId = $(this).find('input[name="item_id[]"]').val();
                        if (existingId === itemId) {
                            isDuplicate = true;
                            return false;
                        }
                    });


                    if (!isDuplicate) {
                        var optionsDepartment = `<option value="">Pilih Departemen</option>
                            @foreach ($masterDepartments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach`;
                        var row = `<tr>
                                        <td><input type="text" name="item_name[]" value="${itemName}" readonly class="form-control" required></td>
                                        <td><input type="text" name="quantity[]" value="" class="form-control quantity" required></td>
                                        <td><input type="text" name="price[]" value="" class="form-control item_price" required></td>
                                        <td><input type="text" name="subtotal[]" value="" readonly class="form-control subtotal"></td>
                                        <input type="hidden" name="header_id[]" readonly value="${headerId}">
                                        <td>
                                            <select name="department_id[]" class="form-control" required>
                                                ${optionsDepartment}
                                            </select>
                                        </td>
                                        <td><button type="button" class="btn btn-danger delete-row">Delete</button></td>
                                        <input type="hidden" name="item_id[]" value="${itemId}">
                                        
                                        
                                    </tr>`;

                        $('#datatable tbody').append(row);
                    } else {
                        alert('This item is already added.');
                    }

                    // Clear the select box
                    $(this).val('');
                }
            });

            // kalkulasi kuantitas * harga =  subtotal
            function updateSubtotal(row) {
                var quantity = parseFloat(row.find('.quantity').val()) || 0;
                var price = parseFloat(row.find('.item_price').val()) || 0;
                var subtotal = quantity * price;
                row.find('.subtotal').val(subtotal.toFixed(2));
                console.log(`Updated subtotal: ${subtotal.toFixed(2)}`); // Debugging
            }

            function updateTotal() {
                var total = 0;
                $('#datatable .subtotal').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#total').val(total.toFixed(2));
            }
            // Event listener for quantity and price changes
            $('#datatable').on('input', '.quantity, .item_price', function() {
                var row = $(this).closest('tr');
                updateSubtotal(row);
                updateTotal();
            });


            $('#datatable').on('click', '.delete-row', function() {
                $(this).closest('tr').remove();
                updateTotal();
            });

            updateTotal();
        });
    </script>
</body>

</html>
