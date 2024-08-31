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
                    <h1 class="mt-4">Master Department Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Master Deparment Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('departments.create') }}">Tambah Departemen</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan master departemen dan merupakan kewenangan admin, apabila ada
                            masalah silakan hubungi kewenangan
                            diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Master Department
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No Telpon</th>
                                        <th>Contact Person</th>
                                        <th>No Contact Person</th>
                                        <th>Perusahaan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No Telpon</th>
                                        <th>Contact Person</th>
                                        <th>No Contact Person</th>
                                        <th>Perusahaan</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($departments as $department)
                                        <tr>
                                            <td>{{ $department->id }}</td>
                                            <td>{{ $department->name }}</td>
                                            <td>{{ $department->address }}</td>
                                            <td>{{ $department->department_number }}</td>
                                            <td>{{ $department->contact_person }}</td>
                                            <td>{{ $department->contact_person_number }}</td>
                                            <td>{{ $department->masterCompany->name }}</td>
                                            <td><a class="btn btn-warning"
                                                    href="{{ route('departments.edit', $department->id) }}">edit</a>
                                                <a href="#" class="btn btn-danger"
                                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this department?')) { document.getElementById('delete-department-{{ $department->id }}').submit(); }">Delete</a>

                                                <form id="delete-department-{{ $department->id }}"
                                                    action="{{ route('departments.destroy', $department->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
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
</body>

</html>
