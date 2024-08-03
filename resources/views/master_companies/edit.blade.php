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
                    <h1 class="mt-4">Edit Perusahaan</h1>
                    <form action="{{ route('companies.update', $company->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">

                            <label for="name">Nama:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $company->name }}">
                            <label for="address">Alamat:</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ $company->address }}">
                            <label for="company_number">Nomor Perusahaan:</label>
                            <input type="text" class="form-control" id="company_number" name="company_number"
                                value="{{ $company->company_number }}">
                            <label for="contact_person">Contact Person:</label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person"
                                value="{{ $company->contact_person }}">
                            <label for="contact_person_number">No Contact Person:</label>
                            <input type="text" class="form-control" id="contact_person_number"
                                name="contact_person_number" value="{{ $company->contact_person_number }}">

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
