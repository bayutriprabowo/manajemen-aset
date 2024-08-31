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
                    <h1 class="mt-4">Edit Departemen</h1>
                    <form action="{{ route('departments.update', $department->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">

                            <label for="name">Nama:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $department->name }}">
                            <label for="address">Alamat:</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ $department->address }}">
                            <label for="department_number">Nomor Perusahaan:</label>
                            <input type="text" class="form-control" id="department_number" name="department_number"
                                value="{{ $department->department_number }}">
                            <label for="contact_person">Contact Person:</label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person"
                                value="{{ $department->contact_person }}">
                            <label for="contact_person_number">No Contact Person:</label>
                            <input type="text" class="form-control" id="contact_person_number"
                                name="contact_person_number" value="{{ $department->contact_person_number }}">
                            <label for="company_id">Perusahaan:</label>
                            <select class="form-control" id="company_id" name="company_id">
                                @foreach ($masterCompanies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ $department->company_id == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Choices.js for the company_id select element
            var companySelect = new Choices('#company_id', {
                shouldSort: false
            });
        });
    </script>
</body>

</html>
