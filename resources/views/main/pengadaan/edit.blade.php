<div class="col-12">
    <form id="formEdit">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ubah Data Pengadaan</div>
                <div class="card-options">
                    <button class="btn btn-info btn-data" type="button">
                        <i class="fa fa-eye"></i> Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="pemohon">Nama Pemohon</label>
                            <input type="text" class="form-control pemohon" name="pemohon" id="pemohon" placeholder="masukkan nama pemohon" value="{{$data->pemohon}}">
                            <div class="invalid-feedback error-pemohon"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="jabatan_pemohon">Jabatan Pemohon</label>
                            <input type="text" class="form-control jabatan_pemohon" name="jabatan_pemohon" id="jabatan_pemohon" placeholder="masukkan jabatan pemohon" value="{{$data->jabatan_pemohon}}">
                            <div class="invalid-feedback error-jabatan_pemohon"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" value="{{$data->id_pengadaan}}" name="id_pengadaan">
                    <label for="nomor-laporan">Nomor Laporan</label>
                    <input type="text" class="form-control nomor_laporan" name="nomor_laporan" id="nomor-laporan" placeholder="masukkan nomor laporan" value="{{$data->nomor_laporan}}">
                    <div class="invalid-feedback error-nomor_laporan"></div>
                </div>
                <div class="form-group">
                    <label for="tanggal-pengadaan">Tanggal Pengadaan</label>
                    <input type="date" class="form-control tanggal_pengadaan" name="tanggal_pengadaan" id="tanggal-pengadaan" placeholder="masukkan tanggal pengadaan barang" value="{{$data->tanggal_pengadaan}}">
                    <div class="invalid-feedback error-tanggal_pengadaan"></div>
                </div>
                <div class="form-group">
                    <label for="tanggal-penerimaan">Tanggal Penerimaan</label>
                    <input type="date" class="form-control tanggal_penerimaan" name="tanggal_penerimaan" id="tanggal-penerimaan" placeholder="masukkan tanggal penerimaan barang" value="{{$data->tanggal_penerimaan}}">
                    <div class="invalid-feedback error-tanggal_penerimaan"></div>
                </div>
                <div class="form-group">
                    <label for="biaya">Biaya</label>
                    <input type="text" class="form-control biaya" name="biaya" id="biaya" placeholder="masukkan biaya" value="{{convertToRupiah($data->biaya_pengadaan)}}">
                    <div class="invalid-feedback error-biaya"></div>
                </div>
                {{-- <div class="form-group">
                    <label for="nota">Nota</label>
                    <input type="file" class="form-control nota" name="nota" id="nota" placeholder="masukkan nota">
                    <span class="text-muted text-small">*kosongkan bila tidak ingin mengubah nota</span>
                    <div class="invalid-feedback error-nota"></div>
                </div> --}}
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control keterangan" name="keterangan" id="keterangan" placeholder="masukkan keterangan" rows="5">{{$data->keterangan}}</textarea>
                    <div class="invalid-feedback error-keterangan"></div>
                </div>
            </div>
        </div>
        <div id="item-barang">
            @foreach ($data->item_pengadaan as $item)
            {{-- {{$item}} --}}
            <div class="card">
                <div class="card-header">Item Barang</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" class="form-control nama0" name="nama[0]" id="nama0" placeholder="masukkan nama barang" value="{{$item->barang->nama_barang}}">
                        <div class="invalid-feedback error-nama0"></div>
                    </div>
                    <div class="form-group">
                        <label for="merek">Merek Barang</label>
                        <input type="text" class="form-control merek0" name="merek[0]" id="merek0" placeholder="masukkan merek barang" value="{{$item->barang->merek}}">
                        <div class="invalid-feedback error-merek0"></div>
                    </div>
                    <div class="form-group">
                        <label for="spesifikasi">Spesifikasi Barang</label>
                        <textarea class="form-control spesifikasi0" name="spesifikasi[0]" id="spesifikasi0" placeholder="masukkan spesifikasi barang">{{$item->barang->spesifikasi}}</textarea>
                        <div class="invalid-feedback error-spesifikasi0"></div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Barang</label>
                        <input type="number" class="form-control jumlah0" name="jumlah[0]" id="jumlah0" placeholder="masukkan jumlah barang" value="{{$item->jumlah_barang}}">
                        <div class="invalid-feedback error-jumlah0"></div>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga Satuan</label>
                        <input type="text" class="form-control harga-satuan harga0" name="harga[0]" id="harga0" placeholder="masukkan harga satuan barang" value="{{convertToRupiah($item->harga_satuan)}}">
                        <div class="invalid-feedback error-harga0"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="form-group">
            <button class="btn btn-success btn-add-item col-2 mb-2" type="button">
                <i class="fa fa-save"></i> Tambah Item
            </button>
            <button class="btn btn-success btn-update pull-right" type="button">
                <i class="fa fa-save"></i> Simpan
            </button>
        </div>
    </form>
</div>