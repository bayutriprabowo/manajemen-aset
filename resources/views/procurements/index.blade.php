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
                    <h1 class="mt-4">Transaction Procurement Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transaction Procurement Tables</li>
                    </ol>
                    <a class="btn btn-success" href="{{ route('procurements.create') }}">Tambah Pengadaan</a>
                    <div class="card mb-4">
                        <div class="card-body">
                            Data ini merupakan pengadaan, apabila ada
                            masalah silakan hubungi kewenangan diatasnya.
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Pengadaan
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Kode</th>
                                        <th>Keterangan</th>
                                        <th>Total</th>
                                        <th>Vendor</th>
                                        <th>Pengusul</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Kode</th>
                                        <th>Keterangan</th>
                                        <th>Total</th>
                                        <th>Vendor</th>
                                        <th>Pengusul</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    @foreach ($procurementHeaders as $header)
                                        <tr>
                                            <td>{{ $header->id }}</td>
                                            <td>{{ $header->transaction_date }}</td>
                                            <td>
                                                {{-- {{ $header->status }} --}}
                                                @if ($header->status == 'approved')
                                                    <button class="btn btn-success btn-sm">Disetujui</button>
                                                @elseif ($header->status == 'rejected')
                                                    <button class="btn btn-warning btn-sm">Ditolak</button>
                                                @elseif ($header->status == 'in_progress')
                                                    <button class="btn btn-primary btn-sm">Proses</button>
                                                @endif
                                            </td>
                                            <td>{{ $header->code }}</td>
                                            <td>{{ $header->description }}</td>
                                            <td>{{ number_format($header->total, 2, ',', '.') }}</td>
                                            <td>{{ $header->masterVendor->name }}</td>
                                            <td>{{ $header->user->name }}</td>

                                            <td>
                                                @if (auth()->user()->masterRole->name == 'superuser')
                                                    @if ($header->status != 'approved')
                                                        <a href="#" class="btn btn-success"
                                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to approve this procurement?')) { document.getElementById('approve-procurement-{{ $header->id }}').submit(); }"><i
                                                                class="fa fa-check-circle" aria-hidden="true"></i></a>
                                                    @endif
                                                @endif

                                                @if (auth()->user()->masterRole->name == 'superuser' || auth()->user()->masterRole->name == 'admin')
                                                    <a class="btn btn-primary"
                                                        href="{{ route('procurements.detail', $header->id) }}"><i
                                                            class="fa fa-eye" aria-hidden="true"></i></a>
                                                @endif

                                                @if (auth()->user()->masterRole->name == 'superuser')
                                                    @if ($header->status != 'rejected')
                                                        <a href="#" class="btn btn-warning"
                                                            onclick="event.preventDefault(); if(confirm('Are you sure you want to reject this procurement?')) { document.getElementById('reject-procurement-{{ $header->id }}').submit(); }"><i
                                                                class="fa fa-ban" aria-hidden="true"></i></i></a>
                                                    @endif
                                                @endif

                                                {{-- <a class="btn btn-warning" href="{{ route('vendors.edit', $vendor->id) }}">edit</a> --}}
                                                @if (auth()->user()->masterRole->name == 'superuser')
                                                    <a href="#" class="btn btn-danger"
                                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this procurement?')) { document.getElementById('delete-procurement-{{ $header->id }}').submit(); }"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></a>
                                                @endif


                                                <form id="delete-procurement-{{ $header->id }}"
                                                    action="{{ route('procurements.destroy', $header->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <form id="approve-procurement-{{ $header->id }}"
                                                    action="{{ route('procurements.approve', $header->id) }}"
                                                    method="POST" style="display: none;">
                                                    <input name="status" type="text" value="approved">
                                                    @csrf
                                                    @method('PUT')
                                                </form>

                                                <form id="reject-procurement-{{ $header->id }}"
                                                    action="{{ route('procurements.reject', $header->id) }}"
                                                    method="POST" style="display: none;">
                                                    <input name="status" type="text" value="rejected">
                                                    @csrf
                                                    @method('PUT')
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
