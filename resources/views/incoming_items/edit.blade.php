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
                    <h1 class="mt-4">Edit Vendor</h1>
                    <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">

                            <label for="name">Nama:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $vendor->name }}">
                            <label for="address">Alamat:</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ $vendor->address }}">
                            <label for="office_number">No Telpon Kantor:</label>
                            <input type="text" class="form-control" id="office_number" name="office_number"
                                value="{{ $vendor->office_number }}">
                            <label for="owner">Pemilik:</label>
                            <input type="text" class="form-control" id="owner" name="owner"
                                value="{{ $vendor->owner }}">
                            <label for="owner_number">No Telpon Pemilik:</label>
                            <input type="text" class="form-control" id="owner_number" name="owner_number"
                                value="{{ $vendor->owner_number }}">


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
