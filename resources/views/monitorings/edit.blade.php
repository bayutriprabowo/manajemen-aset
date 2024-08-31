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
                    <h1>Form Edit Pengadaan</h1>
                    {{-- <button id="addRow" class="btn btn-success">Add Row</button> --}}




                    <form id="dataForm" action="{{ route('monitorings.update', $id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <table class="table" id="">
                            <thead>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Item</th>
                                <th>Departemen</th>
                                <th>User</th>
                                <th>Kode</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Kuantitas</th>
                                <th>Biaya</th>
                                <th>Bukti</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $monitoringForm->id }}</td>
                                    <td>{{ $monitoringForm->transaction_date }}</td>
                                    <td>{{ $monitoringForm->masterItem->name }}</td>
                                    <td>{{ $monitoringForm->masterDepartment->name }}</td>
                                    <td>{{ $monitoringForm->user->name }}</td>
                                    <td>{{ $monitoringForm->code }}</td>
                                    <td>
                                        {{-- {{ $monitoringForm->status }} --}}
                                        @if ($monitoringForm->period == 'daily')
                                            <button class="btn btn-primary btn-sm">Harian</button>
                                        @elseif ($monitoringForm->period == 'weekly')
                                            <button class="btn btn-warning btn-sm">Mingguan</button>
                                        @elseif ($monitoringForm->period == 'monthly')
                                            <button class="btn btn-success btn-sm">Bulanan</button>
                                        @elseif ($monitoringForm->period == 'yearly')
                                            <button class="btn btn-danger btn-sm">Tahunan</button>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- {{ $monitoringForm->status }} --}}
                                        @if ($monitoringForm->status == 'in_progress')
                                            <button class="btn btn-primary btn-sm">Proses</button>
                                        @elseif ($monitoringForm->status == 'postponed')
                                            <button class="btn btn-warning btn-sm">Ditunda</button>
                                        @elseif ($monitoringForm->status == 'completed')
                                            <button class="btn btn-success btn-sm">Selesai</button>
                                        @elseif ($monitoringForm->status == 'cancelled')
                                            <button class="btn btn-danger btn-sm">Dibatalkan</button>
                                        @endif
                                    </td>
                                    <td>{{ $monitoringForm->description }}</td>
                                    <td>{{ $monitoringForm->quantity }}</td>
                                    <td>{{ $monitoringForm->cost }}</td>
                                    <td>
                                        @if ($monitoringForm->photo_proof)
                                            <img src="{{ asset('storage/' . $monitoringForm->photo_proof) }}"
                                                alt="Photo Proof" style="max-width: 100px; max-height: 100px;">
                                        @else
                                            No Proof Available
                                        @endif
                                    </td>
                                <tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    {{-- <th>Item</th> --}}
                                    {{-- <th>Departemen</th> --}}
                                    <th>User</th>
                                    <th>Kode</th>


                                </tr>
                                <tr>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <input type="hidden" name="id" id="id"
                                        data-header="{{ $id }}" value="{{ $id }}" readonly>
                                    <td><input type="date" name="transaction_date"
                                            value="{{ $monitoringForm->transaction_date }}" required></td>
                                    <td class="col-3"><select name="item_id" id="item_id"
                                            class="form-control item-id mb-3" required readonly>
                                            <option value="{{ $monitoringForm->item_id }}">
                                                {{ $monitoringForm->masterItem->name }}</option>
                                            {{-- @foreach ($masterItems as $item)
                                                <option value="{{ $item->id }}" data-nama="{{ $item->name }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                    </td>
                                    <td class="col-3"><select name="department_id" id="department_id"
                                            class="form-control department_id mb-3" required readonly>
                                            <option value="{{ $monitoringForm->department_id }}">
                                                {{ $monitoringForm->masterDepartment->name }}</option>
                                            {{-- @foreach ($masterDepartments as $department)
                                                <option value="{{ $department->id }}"
                                                    data-nama="{{ $department->name }}">
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                    </td>

                                    <td><input type="hidden" name="user_id" value="{{ auth()->user()->id }}"
                                            readonly>{{ auth()->user()->name }}</td>
                                    <td><input type="text" name="code" value="{{ $monitoringForm->code }}"
                                            readonly>


                                </tr>


                            </tbody>
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-3"><select name="period" id="period"
                                            class="form-control item-id mb-3" required>
                                            <option value="{{ $monitoringForm->period }}">
                                                @if ($monitoringForm->period == 'daily')
                                                    Harian
                                                @elseif ($monitoringForm->period == 'weekly')
                                                    Mingguan
                                                @elseif ($monitoringForm->period == 'monthly')
                                                    Bulanan
                                                @elseif ($monitoringForm->period == 'yearly')
                                                    Tahunan
                                                @endif
                                            </option>
                                            <option value="daily">Harian</option>
                                            <option value="weekly">Mingguan</option>
                                            <option value="monthly">Bulanan</option>
                                            <option value="yearly">Tahunan</option>
                                        </select>
                                    </td>
                                    <td class="col-3">
                                        <select name="status" id="status" class="form-control item-id mb-3"
                                            required>
                                            <option value="{{ $monitoringForm->status }}">
                                                @if ($monitoringForm->status == 'in_progress')
                                                    Proses
                                                @elseif ($monitoringForm->status == 'postponed')
                                                    Ditunda
                                                @elseif ($monitoringForm->status == 'completed')
                                                    Selesai
                                                @elseif ($monitoringForm->status == 'cancelled')
                                                    Dibatalkan
                                                @endif
                                            </option>
                                            <option value="in_progress">Proses</option>
                                            <option value="postponed">Ditunda</option>
                                            <option value="completed">Selesai</option>
                                            <option value="cancelled">Dibatalkan</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="description"
                                            value="{{ $monitoringForm->description }}" required></td>


                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th>Kuantitas</th>
                                    <th>Biaya</th>
                                    <th>Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="quantity" id="quantity" value="0" required>
                                    </td>
                                    <td><input type="text" name="cost" id="cost" value="0.00" required>
                                    </td>


                                    <td><input type="file" name="photo_proof" id="photo_proof"></td>
                                </tr>
                            </tbody>

                        </table>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                    <!-- isi table -->
                </div>
            </main>






            @include('templates.footer')
        </div>
        <!-- end layout content-->
    </div>
    <!-- end layout sidenav -->
    @include('templates.script')

    {{-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> --}}
    <script src="cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemSelect = new Choices('#item_id', {
                searchPlaceholderValue: 'Search for an item',
                noResultsText: 'No items found',
                removeItemButton: true,
                itemSelectText: '' // Menghilangkan "Press to select"
            });

            const departmentSelect = new Choices('#department_id', {
                searchPlaceholderValue: 'Search for a department',
                noResultsText: 'No departments found',
                removeItemButton: true,
                itemSelectText: '' // Menghilangkan "Press to select"
            });

            const periodSelect = new Choices('#period', {
                searchPlaceholderValue: 'Search for a period',
                noResultsText: 'No periods found',
                removeItemButton: true,
                itemSelectText: '' // Menghilangkan "Press to select"
            });

            const statusSelect = new Choices('#status', {
                searchPlaceholderValue: 'Search for a status',
                noResultsText: 'No status found',
                removeItemButton: true,
                itemSelectText: '' // Menghilangkan "Press to select"
            });
        });
    </script>
</body>

</html>
