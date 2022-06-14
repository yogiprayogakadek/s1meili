<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Data Pegawai</div>
            <div class="card-options">
                @can('manage_data')
                <button class="btn btn-primary btn-add">
                    <i class="fa fa-plus"></i> Tambah
                </button>
                @endcan
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
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Ruangan</th>
                        <th>TTL</th>
                        <th>No. Telp</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>
                        <th>Foto</th>
                        @can('manage_data') 
                        <th>Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->nip}}</td>
                        <td>{{$data->nama_pegawai}}</td>
                        <td>{{$data->jabatan}}</td>
                        <td>{{$data->ruangan}}</td>
                        <td>{{$data->tempat_lahir}}, {{convertDate($data->tanggal_lahir)}}</td>
                        <td>{{$data->no_telp}}</td>
                        <td>{{$data->alamat}}</td>
                        <td>{{$data->jenis_kelamin}}</td>
                        <td><img src="{{asset($data->foto)}}" width="100px"></td>
                        @can('manage_data')     
                        <td>
                            <button class="btn btn-primary btn-edit" data-id="{{$data->id_pegawai}}">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-delete" data-id="{{$data->id_pegawai}}">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </td>
                        @endcan
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