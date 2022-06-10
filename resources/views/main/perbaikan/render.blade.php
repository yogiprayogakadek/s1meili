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
            <table class="table table-bordered text-nowrap border-bottom dataTable no-footer" role="grid" id="tableData">
                <thead>
                    <tr>
                        <th></th>
                        <th>User</th>
                        <th>Tanggal Perbaikan</th>
                        <th>Nomor Laporan</th>
                        <th>Status Perbaikan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $data)
                    <tr>
                        <td data-keterangan="{{$data->keterangan_perbaikan}}" data-pemohon="{{$data->pemohon}}" data-jabatan="{{$data->jabatan_pemohon}}" data-id="{{$data->id_perbaikan}}">
                            <i class="fa fa-plus-circle"></i>
                        </td>
                        <td>{{$data->user->nama}}</td>
                        <td>{{$data->tanggal_perbaikan}}</td>
                        <td>{{$data->nomor_laporan}}</td>
                        {{-- <td>{{$data->status_perbaikan}}</td> --}}
                        <td>{!!$data->perbaikan_histori == null ? $data->status_perbaikan : '<button class="btn btn-primary btn-detail-validasi" data-id="'.$data->id_perbaikan.'"><i class="fa fa-eye"></i> Lihat Status</button>' !!}</td>
                        <td>
                            <button class="btn btn-success btn-edit" data-id="{{$data->id_perbaikan}}">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-delete" data-id="{{$data->id_perbaikan}}">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                            <button class="btn btn-success btn-validasi" data-id="{{$data->id_perbaikan}}" data-status="{{$data->status_perbaikan}}">
                                <i class="fa fa-check-circle-o"></i> Validasi
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Validasi -->
<div class="modal fade" id="modalValidasi" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validasi Data Perbaikan</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_perbaikan" id="id_perbaikan">
                <div class="form-group">
                    <label for="">Status Perbaikan</label>
                    <select class="form-control" name="status_perbaikan" id="status_perbaikan">
                        <option value="">Pilih Status Perbaikan</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                    <div class="invalid-feedback error-status"></div>
                </div>
                <div class="form-group" id="keterangan_grup">
                    <label for="">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
                    <div class="invalid-feedback error-keterangan"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-proses-validasi">Validasi</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Validasi -->

{{-- Modal Status Validasi --}}
<div class="modal fade" id="modalStatusValidasi" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Status Data Perbaikan</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless" id="tableValidasi">
                    <thead>
                        <tr>
                            <th>Status Validasi Kepala Sekolah</th>
                            <th>Tanggal Validasi Kepala Sekolah</th>
                            <th>Status Validasi Wakil Sarpras</th>
                            <th>Tanggal Validasi Wakil Sarpras</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>
{{-- Modal Status Validasi --}}

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