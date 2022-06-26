<div class="col-12">
    <form id="formAdd">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Data Pengadaan</div>
                <div class="card-options">
                    <button class="btn btn-info btn-data" type="button">
                        <i class="fa fa-eye"></i> Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                {{-- <form id="formAdd"> --}}
                {{-- <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="pemohon">Nama Pemohon</label>
                            <input type="text" class="form-control pemohon" name="pemohon" id="pemohon" placeholder="masukkan nama pemohon">
                            <div class="invalid-feedback error-pemohon"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="jabatan_pemohon">Jabatan Pemohon</label>
                            <input type="text" class="form-control jabatan_pemohon" name="jabatan_pemohon" id="jabatan_pemohon" placeholder="masukkan jabatan pemohon">
                            <div class="invalid-feedback error-jabatan_pemohon"></div>
                        </div>
                    </div>
                </div> --}}

                <div class="form-group">
                    <label for="pemohon">Nama Pemohon</label>
                    <select name="pemohon" id="pemohon" class="form-control pemohon">
                        @foreach ($pegawai as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback error-pemohon"></div>
                </div>

                <div class="form-group">
                    <label for="nomor-laporan">Nomor Laporan</label>
                    <input type="text" class="form-control nomor_laporan" name="nomor_laporan" id="nomor-laporan" placeholder="masukkan nomor laporan">
                    <div class="invalid-feedback error-nomor_laporan"></div>
                </div>
                <div class="form-group">
                    <label for="tanggal-pengadaan">Tanggal Pengadaan</label>
                    <input type="date" class="form-control tanggal_pengadaan" name="tanggal_pengadaan" id="tanggal-pengadaan" placeholder="masukkan tanggal pengadaan barang">
                    <div class="invalid-feedback error-tanggal_pengadaan"></div>
                </div>
                {{-- <div class="form-group">
                    <label for="tanggal-penerimaan">Tanggal Penerimaan</label>
                    <input type="date" class="form-control tanggal_penerimaan" name="tanggal_penerimaan" id="tanggal-penerimaan" placeholder="masukkan tanggal penerimaan barang">
                    <div class="invalid-feedback error-tanggal_penerimaan"></div>
                </div> --}}
                {{-- <div class="form-group">
                    <label for="biaya">Biaya</label>
                    <input type="text" class="form-control biaya" name="biaya" id="biaya" placeholder="masukkan biaya">
                    <div class="invalid-feedback error-biaya"></div>
                </div> --}}
                {{-- <div class="form-group">
                    <label for="nota">Nota</label>
                    <input type="file" class="form-control nota" name="nota" id="nota" placeholder="masukkan nota">
                    <span class="text-muted text-small">*kosongkan bila belum ada nota</span>
                    <div class="invalid-feedback error-nota"></div>
                </div> --}}
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control keterangan" name="keterangan" id="keterangan" placeholder="masukkan keterangan" rows="5"></textarea>
                    <div class="invalid-feedback error-keterangan"></div>
                </div>
                {{-- </form> --}}
            </div>
        </div>
        
        <div id="item-barang">
            <div class="card">
                <div class="card-header">Item Barang</div>
                <div class="card-body">
                    {{-- <div class="form-group">
                        <label for="kode">Kode Barang</label>
                        <input type="text" class="form-control kode0" name="kode[0]" id="kode0" placeholder="masukkan kode barang">
                        <div class="invalid-feedback error-kode0"></div>
                    </div> --}}
                    <div class="form-group">
                        <label for="nama">Nama nama</label>
                        <select name="nama[0]" id="nama0" class="form-control nama0 nama-barang" data-id="0">
                            @foreach ($barang as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback error-nama0"></div>
                    </div>
                    {{-- <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" class="form-control nama0" name="nama[0]" id="nama0" placeholder="masukkan nama barang">
                        <div class="invalid-feedback error-nama0"></div>
                    </div> --}}
                    <div class="form-group">
                        <label for="merek">Merek Barang</label>
                        <input type="text" class="form-control merek0" name="merek[0]" id="merek0" placeholder="masukkan merek barang" readonly>
                        <div class="invalid-feedback error-merek0"></div>
                    </div>
                    <div class="form-group">
                        <label for="spesifikasi">Spesifikasi Barang</label>
                        <textarea class="form-control spesifikasi0" name="spesifikasi[0]" id="spesifikasi0" placeholder="masukkan spesifikasi barang" readonly></textarea>
                        <div class="invalid-feedback error-spesifikasi0"></div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Barang</label>
                        <input type="number" class="form-control jumlah0" name="jumlah[0]" id="jumlah0" placeholder="masukkan jumlah barang">
                        <div class="invalid-feedback error-jumlah0"></div>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga Satuan</label>
                        <input type="text" class="form-control harga-satuan harga0" name="harga[0]" id="harga0" data-harga="harga0" placeholder="masukkan harga satuan barang">
                        <div class="invalid-feedback error-harga0"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-success btn-add-item col-2 mb-2" type="button">
                <i class="fa fa-save"></i> Tambah Item
            </button>
            <button class="btn btn-success btn-save pull-right" type="button">
                <i class="fa fa-save"></i> Simpan
            </button>
        </div>
    </form>
</div>