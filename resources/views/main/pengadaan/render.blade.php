<div class="col-12">
    <div class="card">
        <div class="card-header">
            @cannot('bendahara')
            <div class="card-title">Data Barang</div>
            @endcannot
            @can('bendahara')
            <div class="card-title">Data Perbaikan</div>
            @endcan
            <div class="card-options">
                <div class="form-group" style="margin-right: 2px">
                    <input type="date" class="form-control" id="start_date" value="{{date('Y-m-01')}}">
                </div>
                <div class="form-group" style="margin-right: 3px">
                    <input type="date" class="form-control" id="end_date" value="{{date("Y-m-t", strtotime(date('Y-m-01')))}}" min="{{date('Y-m-01')}}">
                </div>
                <div class="form-group" style="margin-right: 3px">
                    <select name="status" id="status" class="form-control">
                        <option value="Semua">Semua Status</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Ditolak">Ditolak</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-info btn-lg" id="btn-search">
                        <i class="fe fe-search"></i>
                    </button>
                    <button class="btn btn-success btn-lg btn-print">
                        <i class="fe fe-printer"></i>
                    </button>
                    <button class="btn btn-primary btn-lg" id="btn-refresh">
                        <i class="fe fe-refresh-cw"></i>
                    </button>
                    @can('manage_data')
                    <button class="btn btn-primary btn-add btn-lg">
                        <i class="fe fe-plus"></i>
                    </button>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-nowrap border-bottom dataTable no-footer table-responsive" role="grid" id="tableData">
                <thead>
                    <tr>
                        <th></th>
                        {{-- <th>No</th> --}}
                        <th>Nama Pemohon</th>
                        <th>Tanggal Pengadaan</th>
                        {{-- <th>Tanggal Penerimaan</th> --}}
                        <th>Nomor Laporan</th>
                        <th>Biaya Pengadaan</th>
                        <th>Nota</th>
                        {{-- <th>Keterangan</th> --}}
                        <th>Status Pengadaan</th>
                        @cannot('bendahara')
                        <th>Aksi</th>
                        @endcannot
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $data)
                    <tr>
                        <td data-keterangan="{{$data->keterangan}}" data-pemohon="{{$data->pegawai->nama_pegawai}}" data-jabatan="{{$data->pegawai->jabatan}}" data-id="{{$data->id_pengadaan}}" data-status="{{$data->status_pengadaan}}">
                            <i class="fa fa-plus-circle"></i>
                        </td>
                        {{-- <td>{{$loop->iteration}}</td> --}}
                        <td>{{$data->pegawai->nama_pegawai}}</td>
                        <td>{{$data->tanggal_pengadaan}}</td>
                        {{-- <td>{{$data->tanggal_penerimaan}}</td> --}}
                        <td>{{$data->nomor_laporan}}</td>
                        <td>{{convertToRupiah($data->biaya_pengadaan)}}</td>
                        <td>
                            @cannot('bendahara')
                            {!!$data->nota == null ? '-' : '<a href="'.asset($data->nota).'" target="_blank">Lihat Nota</a>'!!}
                            @endcannot
                            @can('bendahara')
                                @if ($data->nota == null)
                                <button class="btn {{$data->status_pengadaan == 'Diterima' ? 'btn-info btn-nota' : 'btn-disabled'}}" data-id="{{$data->id_pengadaan}}" {{$data->status_pengadaan == 'Ditolak' ? 'disabled' : ''}}>
                                    <i class="fa fa-upload"></i> Unggah Data
                                </button>
                                @else
                                <button class="btn btn-success btn-detail-nota" data-id="{{$data->id_pengadaan}}" data-nota="{{$data->nota}}">
                                    <i class="fa fa-eye"></i> Detail Data
                                </button>
                                @endif
                            @endcan
                        </td>
                        {{-- <td>{{$data->keterangan}}</td> --}}
                        @if ($data->status_pengadaan != 'Dibatalkan')
                            <td>{!!$data->pengadaan_histori == null ? $data->status_pengadaan : '<button class="btn btn-primary btn-detail-validasi" data-id="'.$data->id_pengadaan.'"><i class="fa fa-eye"></i> Lihat Status</button>' !!}</td>
                        @else
                            <td>{{$data->status_pengadaan}}</td>
                        @endif
                        @can('manage_data')
                        @if ($data->status_pengadaan != 'Dibatalkan')
                        <td>
                            <button class="btn btn-success btn-edit" data-id="{{$data->id_pengadaan}}">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-batal" data-id="{{$data->id_pengadaan}}">
                                <i class="fa fa-trash"></i> Batal
                            </button>
                            {{-- <button class="btn btn-danger btn-delete" data-id="{{$data->id_pengadaan}}">
                                <i class="fa fa-trash"></i> Hapus
                            </button> --}}
                        </td>
                        @else
                        <td>
                            <button class="btn btn-info btn-detail-pembatalan" data-id="{{$data->id_pengadaan}}">
                                <i class="fa fa-eye"></i> Status Dibatalkan
                            </button>
                        </td>
                        @endif
                        @endcan
                        @can('validator')
                        @if ($data->status_pengadaan != 'Dibatalkan')
                        <td>
                            @can('kepala_sekolah')
                            <button class="btn btn-success btn-validasi" data-id="{{$data->id_pengadaan}}" data-status="{{$data->status_pengadaan}}" data-validasi="{{$data->pengadaan_histori->approve_wakil_sarpras}}">
                                <i class="fa fa-check-circle-o"></i> Validasi
                            </button>
                            @endcan
                            @can('wakil_sarpras')
                            <button class="btn btn-success btn-validasi" data-id="{{$data->id_pengadaan}}" data-status="{{$data->status_pengadaan}}">
                                <i class="fa fa-check-circle-o"></i> Validasi
                            </button>
                            @endcan
                        </td>
                        @else
                        <td>
                            <button class="btn btn-info btn-detail-pembatalan" data-id="{{$data->id_pengadaan}}">
                                <i class="fa fa-eye"></i> Status Dibatalkan
                            </button>
                        </td>
                        @endif
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Pembatalan -->
<div class="modal fade" id="modalPembatalan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pembatalan</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_pengadaan" id="id_pengadaan">
                <div class="form-group">
                    <label for="">Nama Pegawai</label>
                    <select class="form-control" name="id_pegawai" id="id_pegawai">
                        @foreach ($pegawai as $index => $val)
                            <option value="{{$index}}">{{$val}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback error-id_pegawai"></div>
                </div>
                <div class="form-group">
                    <label for="">Tanggal Pembatalan</label>
                    <input type="date" name="tanggal_pembatalan" id="tanggal_pembatalan" class="form-control">
                    <div class="invalid-feedback error-tanggal_pembatalan"></div>
                </div>
                <div class="form-group">
                    <label for="">Keterangan</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
                    <div class="invalid-feedback error-keterangan"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-proses-pembatalan">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Validasi -->

{{-- Modal Status Pembatalan --}}
<div class="modal fade" id="modalStatusPembatalan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Status Pembatalan</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless" id="tablePembatalan">
                    <thead>
                        <tr>
                            <th>Nama Pembatalan</th>
                            <th>Tanggal Pembatalan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>
{{-- Modal Status Validasi --}}

<!-- Modal Validasi -->
<div class="modal fade" id="modalPenerimaan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Penerimaan Barang</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_pengadaan" id="id_pengadaan">
                <div class="form-group">
                    <label for="">Nama Pegawai</label>
                    <select class="form-control" name="id_pegawai" id="id_pegawai">
                        @foreach ($pegawai as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback error-id_pegawai"></div>
                </div>
                <div class="form-group">
                    <label for="">Tanggal Penerimaan</label>
                    <input type="date" name="tanggal_penerimaan" id="tanggal_penerimaan" class="form-control">
                    <div class="invalid-feedback error-tanggal_penerimaan"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-proses-penerimaan">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Validasi -->

<!-- Modal Validasi -->
<div class="modal fade" id="modalValidasi" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validasi Data Pengadaan</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_pengadaan" id="id_pengadaan">
                <div class="form-group">
                    <label for="">Status Pengadaan</label>
                    <select class="form-control" name="status_pengadaan" id="status_pengadaan">
                        <option value="">Pilih Status Pengadaan</option>
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
                <h5 class="modal-title">Status Data Pengadaan</h5>
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

{{-- Modal Detail Nota --}}
<div class="modal fade" id="modalDetailNota" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Nota</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="detail-nota"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-nota">Ubah Nota</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>
{{-- Modal Detail Nota --}}

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