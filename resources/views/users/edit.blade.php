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
                    <h1 class="mt-4">Edit User</h1>
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nip">NIP:</label>
                            <input type="text" class="form-control" id="nip" name="nip"
                                value="{{ $user->nip }}">
                            <label for="name">Nama:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user->name }}">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $user->email }}">
                            <label for="password">Password:</label>
                            <input type="text" class="form-control" id="password" name="password" value="">
                            <label for="address">Alamat:</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ $user->address }}">
                            <label for="position">Posisi:</label>
                            <input type="text" class="form-control" id="position" name="position"
                                value="{{ $user->position }}">

                            <label for="company_id">Perusahaan:</label>
                            <select class="form-control" id="company_id" name="company_id">
                                @foreach ($masterCompany as $company)
                                    <option value="{{ $company->id }}"
                                        {{ $user->company_id == $company->id ? 'selected' : '' }}>{{ $company->name }}
                                    </option>
                                @endforeach
                            </select>

                            <label for="role_id">Role:</label>
                            <select class="form-control" id="role_id" name="role_id">
                                @foreach ($masterRole as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                    </form>
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
