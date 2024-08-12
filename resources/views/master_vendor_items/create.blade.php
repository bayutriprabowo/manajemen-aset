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
                    <h1>Form Input Vendor Item</h1>
                    {{-- <button id="addRow" class="btn btn-success">Add Row</button> --}}

                    <select name="item" id="addRow" class="form-control item-id mb-3">
                        <option value="">Pilih Item</option>
                        @foreach ($masterItems as $item)
                            <option value="{{ $item->id }}" data-nama="{{ $item->name }}"
                                data-harga="{{ $item->price }}">{{ $item->name }}</option>
                        @endforeach
                    </select>


                    <form id="dataForm" action="{{ route('vendor_items.store', $id) }}" method="POST">
                        @csrf
                        <table id="datatable" class="display">
                            <thead>
                                <tr>
                                    <th>Name Item</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
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
            $('#addRow').change(function() {
                var itemId = $(this).val();
                var itemName = $(this).find(':selected').data('nama');
                var itemPrice = $(this).find(':selected').data('harga');

                if (itemId && itemName && itemPrice) {
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
                        var row = `<tr>
                                        <td><input type="text" name="item_name[]" value="${itemName}" readonly class="form-control"></td>
                                        <td><input type="text" name="item_price[]" value="${itemPrice}" readonly class="form-control"></td>
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

            $('#datatable').on('click', '.delete-row', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
</body>

</html>
