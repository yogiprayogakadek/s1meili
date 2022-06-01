<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Ubah Kategori</div>
            <div class="card-options">
                <button class="btn btn-info btn-data">
                    <i class="fa fa-eye"></i> Data
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="formEdit">
                <div class="form-group">
                    <input type="text" value="{{$data->id_barang}}" name="id" hidden>
                    <label for="kode">Kode Barang</label>
                    <input type="text" class="form-control" name="kode" id="kode" placeholder="masukkan kode barang" value="{{$data->kode_barang}}">
                    <div class="invalid-feedback error-kode"></div>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Barang</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="masukkan nama barang" value="{{$data->nama_barang}}">
                    <div class="invalid-feedback error-nama"></div>
                </div>
                <div class="form-group">
                    <label for="spesifikasi">Spesifikasi Barang</label>
                    <textarea class="form-control" name="spesifikasi" id="spesifikasi" rows="5">{{$data->spesifikasi}}</textarea>
                    <div class="invalid-feedback error-spesifikasi"></div>
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan Barang</label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="5">{{$data->keterangan}}</textarea>
                    <div class="invalid-feedback error-keterangan"></div>
                </div>
                <div class="form-group pull-right">
                    <button class="btn btn-success btn-update" type="button">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>