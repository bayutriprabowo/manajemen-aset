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
                    <h1>Form Input Item Status</h1>
                    <button id="addRow" class="btn btn-success">Add Row</button>
                    <form id="dataForm" action="{{ route('item_statuses.store') }}" method="POST">
                        @csrf
                        <table id="datatable" class="display">
                            <thead>
                                <tr>

                                    <th>Deskripsi</th>
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

                var newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input type="text" name="description[]" class="form-control" required></td>
                `;

                tbody.appendChild(newRow);
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
