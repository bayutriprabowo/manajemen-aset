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
                    <h1 class="mt-4">Master Section Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Master Section Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('sections.create') }}">Tambah Seksi/Ruangan</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan master seksi/ruangan dan merupakan kewenangan admin, apabila ada
                            masalah silakan hubungi kewenangan
                            diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Master Seksi
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
                                        <th>Departemen</th>
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
                                        <th>Departemen</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($sections as $section)
                                        <tr>
                                            <td>{{ $section->id }}</td>
                                            <td>{{ $section->name }}</td>
                                            <td>{{ $section->address }}</td>
                                            <td>{{ $section->section_number }}</td>
                                            <td>{{ $section->contact_person }}</td>
                                            <td>{{ $section->contact_person_number }}</td>
                                            <td>{{ $section->masterCompany->name }}</td>
                                            <td>{{ $section->masterDepartment->name }}</td>

                                            <td><a class="btn btn-warning"
                                                    href="{{ route('sections.edit', $section->id) }}">edit</a>
                                                <a href="#" class="btn btn-danger"
                                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this section?')) { document.getElementById('delete-section-{{ $section->id }}').submit(); }">Delete</a>

                                                <form id="delete-section-{{ $section->id }}"
                                                    action="{{ route('sections.destroy', $section->id) }}"
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
