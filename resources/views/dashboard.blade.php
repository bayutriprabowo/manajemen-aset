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
                <!-- content wrapper -->
                <div class="container-fluid px-4">
                    <!-- Tulisan title page-->
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard : Navigasi seluruh layanan</li>
                    </ol>
                    <!-- Tulisan title page -->
                    <!-- Content ke kanan dengan row -->
                    <div class="row">
                        <!-- isi pokok content-->
                        @if (auth()->user()->masterRole->name == 'superuser')
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">User</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/users">View
                                            Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Master 1</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Master 2</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Master 3</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Master 4</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <!-- end isi pokok content -->
                    </div>
                    <!-- end content ke kanan dengan row-->
                </div>
                <!-- end content wrapper -->
            </main>
            <!-- end main content -->
            @include('templates.footer')
        </div>
        <!-- end layout content-->
    </div>
    <!-- end layout sidenav -->
    @include('templates.script')
</body>

</html>
