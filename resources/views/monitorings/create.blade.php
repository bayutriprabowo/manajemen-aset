@include('templates.head_create_choices')

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
                    <!-- isi table -->
                    <h1>Form Input Pengadaan</h1>
                    <form id="dataForm" action="{{ route('monitorings.store', $newId) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <table class="table" id="">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Item</th>
                                    <th>Departemen</th>
                                    <th>User</th>
                                    <th>Kode</th>
                                    <th>Periode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <input type="hidden" name="id" id="id"
                                        data-header="{{ $newId }}" value="{{ $newId }}" readonly>
                                    <td><input type="date" name="transaction_date" required></td>
                                    <td>
                                        <select name="item_id" id="item_id" class="form-control item-id mb-3"
                                            required>
                                            <option value="">Pilih Item</option>
                                            @foreach ($masterItems as $item)
                                                <option value="{{ $item->id }}" data-nama="{{ $item->name }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="department_id" id="department_id"
                                            class="form-control department_id mb-3" required>
                                            <option value="">Pilih Departemen</option>
                                            @foreach ($masterDepartments as $department)
                                                <option value="{{ $department->id }}"
                                                    data-nama="{{ $department->name }}">
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" readonly>
                                        {{ auth()->user()->name }}
                                    </td>
                                    <td><input type="text" name="code" value="MON-{{ $newId }}" readonly>
                                    </td>
                                    <td>
                                        <select name="period" id="period" class="form-control item-id mb-3"
                                            required>
                                            <option value="">Pilih Periode</option>
                                            <option value="daily">Harian</option>
                                            <option value="weekly">Mingguan</option>
                                            <option value="monthly">Bulanan</option>
                                            <option value="yearly">Tahunan</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th>Keterangan</th>
                                    <th>Kuantitas</th>
                                    <th>Biaya</th>
                                    <th></th>
                                    <th></th>
                                    <th>Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <input type="hidden" name="status" value="in_progress" readonly>
                                    <td><input type="text" name="description" required></td>
                                    <td><input type="text" name="quantity" id="quantity" value="0" required>
                                    </td>
                                    <td><input type="text" name="cost" id="cost" value="0.00" required>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td><input type="file" name="photo_proof" id="photo_proof"></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </main>
            @include('templates.footer')
        </div>
    </div>
    @include('templates.script')

    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {
            const itemSelect = new Choices('#item_id', {
                searchPlaceholderValue: 'Search item...',
                shouldSort: false
            });

            const departmentSelect = new Choices('#department_id', {
                searchPlaceholderValue: 'Search department...',
                shouldSort: false
            });

            const periodSelect = new Choices('#period', {
                searchPlaceholderValue: 'Search period...',
                shouldSort: false
            });

            $('input[name="transaction_date"]').on('change', function() {
                var selectedDate = $(this).val();
                var formattedDate = selectedDate.replace(/-/g, '');
                var monitoringId = $('#id').val();
                var paddedMonitoringId = monitoringId.padStart(4, '0');
                var newCode = `MON-${formattedDate}${paddedMonitoringId}`;
                $('input[name="code"]').val(newCode);
            });
        });
    </script>
</body>

</html>
