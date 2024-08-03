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
                    <h1 class="mt-4">User Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Tables</li>
                    </ol>
                    <a class="btn btn-success" href="users.create">Tambah User</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan data dari user, mohon jangan diapa-apakan apabila tidak ada kepentigan
                            mendesak. .
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable User
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>Posisi/Jabatan</th>
                                        <th>Perusahaan</th>
                                        <th>Peran</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>Posisi/Jabatan</th>
                                        <th>Perusahaan</th>
                                        <th>Peran</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->nip }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>{{ $user->position }}</td>
                                            <td>{{ $user->masterCompany->name }}</td>
                                            <td>{{ $user->masterRole->name }}</td>
                                            <td><a class="btn btn-warning"
                                                    href="{{ route('users.edit', $user->id) }}">edit</a>
                                                <a href="#" class="btn btn-danger"
                                                    onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this user?')) { document.getElementById('delete-user-{{ $user->id }}').submit(); }">Delete</a>

                                                <form id="delete-user-{{ $user->id }}"
                                                    action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
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
