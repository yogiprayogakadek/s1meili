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
                <div class="row">
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
                </div>

                <div class="form-group">
                    <label for="nomor-laporan">Nomor Laporan</label>
                    <input type="text" class="form-control nomor_laporan" name="nomor_laporan" id="nomor-laporan" placeholder="masukkan nomor laporan">
                    <div class="invalid-feedback error-nomor_laporan"></div>
                </div>
                <div class="form-group">
                    <label for="tanggal-perbaikan">Tanggal Perbaikan</label>
                    <input type="date" class="form-control tanggal_perbaikan" name="tanggal_perbaikan" id="tanggal-perbaikan" placeholder="masukkan tanggal perbaikan barang">
                    <div class="invalid-feedback error-tanggal_perbaikan"></div>
                </div>
                {{-- </form> --}}
            </div>
        </div>
        
        <div id="item-barang">
            <div class="card">
                <div class="card-header">Item Barang</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" class="form-control nama0" name="nama[0]" id="nama0" placeholder="masukkan nama barang">
                        <div class="invalid-feedback error-nama0"></div>
                    </div>
                    <div class="form-group">
                        <label for="spesifikasi">Spesifikasi Barang</label>
                        <textarea class="form-control spesifikasi0" name="spesifikasi[0]" id="spesifikasi0" placeholder="masukkan spesifikasi barang"></textarea>
                        <div class="invalid-feedback error-spesifikasi0"></div>
                    </div>
                    <div class="form-group">
                        <label for="uraian">Uraian Perbaikan Barang</label>
                        <textarea class="form-control uraian0" name="uraian[0]" id="uraian0" placeholder="masukkan uraian barang"></textarea>
                        <div class="invalid-feedback error-uraian0"></div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan Perbaikan</label>
                        <textarea class="form-control keterangan0" name="keterangan[0]" id="keterangan0" placeholder="masukkan keterangan barang"></textarea>
                        <div class="invalid-feedback error-keterangan0"></div>
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