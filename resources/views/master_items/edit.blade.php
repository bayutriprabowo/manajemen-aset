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
                    <h1 class="mt-4">Edit Item</h1>
                    <form action="{{ route('items.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="barcode">Barcode</label>
                            <input type="text" class="form-control" id="barcode" name="barcode"
                                value="{{ $item->barcode }}">
                            <label for="name">Nama:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $item->name }}">
                            <label for="price">Harga(Rp):</label>
                            <input type="text" class="form-control" id="price" name="price"
                                value="{{ number_format($item->price, 0, ',', '') }}">
                            <label for="type_id">Tipe Item/Barang:</label>
                            <select class="form-control" id="type_id" name="type_id">
                                @foreach ($masterItemTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ $item->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}
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
            // Initialize Choices.js on the select element
            new Choices('#type_id', {
                searchEnabled: true
            });

        });
    </script>
</body>

</html>
