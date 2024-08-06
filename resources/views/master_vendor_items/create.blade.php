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
                    <button id="addRow" class="btn btn-success">Add Row</button>
                    <form id="dataForm" action="{{ route('vendor_items.store', $id) }}" method="POST">
                        @csrf
                        <table id="datatable" class="display">
                            <thead>
                                <tr>
                                    <th>Name Item</th>
                                    <th>ID Vendor</th>
                                    <th>Nama Vendor</th>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            try {
                // Initialize DataTable
                var table = new DataTable('#datatable');
                console.log('DataTable initialized successfully');
            } catch (error) {
                console.error('Error initializing DataTable:', error);
            }

            var optionsItem = `<option value="">Pilih Item</option>
                @foreach ($masterItems as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach`;

            // Add row functionality
            document.getElementById('addRow').addEventListener('click', function() {
                var tbody = document.querySelector('#datatable tbody');
                if (!tbody) {
                    console.error('Table body not found');
                    return;
                }

                var newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td style="width: 200px;">
                        <select name="item_id[]" class="form-control item-id" style="width: 200px;" required>
                            ${optionsItem}
                        </select>
                    </td>
                    <td><input type="text" name="vendor_id[]" class="form-control" value="{{ $vendor->id }}" readonly></td>
                    <td><input type="text" name="vendor_name[]" class="form-control" value="{{ $vendor->name }}" readonly></td>
                    
                    <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
                `;

                tbody.appendChild(newRow);
                console.log('New row added');

                // Function to initialize Choices.js for all elements with the class "item-id"
                function initializeChoices() {
                    var elements = document.querySelectorAll('.item-id:not(.choices-initialized)');
                    elements.forEach(function(element) {
                        try {
                            var choices = new Choices(element, {
                                searchEnabled: true
                            });
                            element.classList.add('choices-initialized');
                            console.log('Choices.js initialized successfully for:', element);
                        } catch (error) {
                            console.error('Choices.js gagal:', error);
                        }
                    });
                }

                // Initialize Choices.js for any existing .item-id elements
                initializeChoices();

                // try {
                //     var element = document.querySelector('.item-id');
                //     var choices = new Choices(element, {
                //         searchEnabled: true
                //     });
                //     console.log('Choices.js initialized successfully');
                // } catch (error) {
                //     console.error('Choices js gagal');
                // }
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
