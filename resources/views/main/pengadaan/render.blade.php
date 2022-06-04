<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Data Barang</div>
            <div class="card-options">
                <button class="btn btn-primary btn-add">
                    <i class="fa fa-plus"></i> Tambah
                </button>
                <button class="btn btn-success btn-print" style="margin-left: 2px">
                    <i class="fa fa-print"></i> Cetak
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-nowrap border-bottom dataTable no-footer table-responsive" role="grid" id="tableData">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Tanggal Pengadaan</th>
                        <th>Tanggal Penerimaan</th>
                        <th>Nomor Laporan</th>
                        <th>Biaya Pengadaan</th>
                        <th>Nota</th>
                        <th>Status Pengadaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->user->nama}}</td>
                        <td>{{$data->tanggal_pengadaan}}</td>
                        <td>{{$data->tanggal_penerimaan}}</td>
                        <td>{{$data->nomor_laporan}}</td>
                        <td>{{convertToRupiah($data->biaya_pengadaan)}}</td>
                        <td>{!!$data->nota == null ? '-' : '<a href="'.asset($data->nota).'" target="_blank">Lihat Nota</a>'!!}</td>
                        <td>{{$data->status_pengadaan}}</td>
                        <td>
                            <button class="btn btn-primary btn-item" data-id="{{$data->id_pengadaan}}">
                                <i class="fa fa-eye"></i> Item Pengadaan
                            </button>
                            <button class="btn btn-success btn-edit" data-id="{{$data->id_pengadaan}}">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-delete" data-id="{{$data->id_pengadaan}}">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $('#tableData').DataTable({
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            },
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            lengthMenu: "Menampilkan _MENU_ data",
            search: "Cari:",
            emptyTable: "Tidak ada data tersedia",
            zeroRecords: "Tidak ada data yang cocok",
            loadingRecords: "Memuat data...",
            processing: "Memproses...",
            infoFiltered: "(difilter dari _MAX_ total data)"
        },
        lengthMenu: [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "All"]
        ],
    });
</script>