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
                    <h1>Form Input Departemen</h1>
                    <button id="addRow" class="btn btn-success">Add Row</button>
                    <form id="dataForm" action="{{ route('departments.store') }}" method="POST">
                        @csrf
                        <table id="datatable" class="display">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Alamat</th>
                                    <th>No Telpon</th>
                                    <th>Contact Person</th>
                                    <th>No Contact Person</th>
                                    <th>Perusahaan</th>
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

                var optionsCompany = `<option value="">Pilih Perusahaan</option>
        @foreach ($masterCompanies as $company)
            <option value="{{ $company->id }}">{{ $company->name }}</option>
        @endforeach`;

                var newRow = document.createElement('tr');
                newRow.innerHTML = `
            <td><input type="text" name="name[]" class="form-control" required></td>
            <td><input type="text" name="address[]" class="form-control" required></td>
            <td><input type="text" name="department_number[]" class="form-control" required></td>
            <td><input type="text" name="contact_person[]" class="form-control" required></td>
            <td><input type="text" name="contact_person_number[]" class="form-control" required></td>
            <td class="col-2">
                <select name="company_id[]" class="form-control company-select" required>
                    ${optionsCompany}
                </select>
            </td>
            <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
        `;

                tbody.appendChild(newRow);

                // Initialize Choices.js for the new select element
                var companySelect = new Choices(newRow.querySelector('.company-select'), {
                    shouldSort: false
                });

                console.log('New row added with Choices.js initialized');
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
