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
                    <h1 class="mt-4">Master Companies Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Master Companies Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('companies.create') }}">Tambah Perusahaan</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan master perusahaan dan merupakan kewenangan admin, apabila ada
                            masalah silakan hubungi kewenangan
                            diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Master Companies
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID Tipe</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No Telpon</th>
                                        <th>Contact Person</th>
                                        <th>No Contact Person</th>
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
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($companies as $company)
                                        <tr>
                                            <td>{{ $company->id }}</td>
                                            <td>{{ $company->name }}</td>
                                            <td>{{ $company->address }}</td>
                                            <td>{{ $company->company_number }}</td>
                                            <td>{{ $company->contact_person }}</td>
                                            <td>{{ $company->contact_person_number }}</td>
                                            <td><a class="btn btn-warning"
                                                    href="{{ route('companies.edit', $company->id) }}">edit</a>
                                                <a href="#" class="btn btn-danger"
                                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this user?')) { document.getElementById('delete-company-{{ $company->id }}').submit(); }">Delete</a>

                                                <form id="delete-company-{{ $company->id }}"
                                                    action="{{ route('companies.destroy', $company->id) }}"
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
