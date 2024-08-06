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
                    <h1 class="mt-4">Edit Item Status</h1>
                    <form action="{{ route('item_statuses.update', $itemStatus->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">

                            <label for="description">Deskripsi:</label>
                            <input type="text" class="form-control" id="description" name="description"
                                value="{{ $itemStatus->description }}">
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
