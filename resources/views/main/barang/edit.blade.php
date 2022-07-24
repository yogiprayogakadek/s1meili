<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Ubah Data Barang</div>
            <div class="card-options">
                <button class="btn btn-info btn-data">
                    <i class="fa fa-eye"></i> Data
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="formEdit">
                <input type="text" value="{{$data->id_barang}}" name="id" hidden>
                <div class="form-group">
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
                    <label for="merek">Merek Barang</label>
                    <input type="text" class="form-control" name="merek" id="merek" placeholder="masukkan merek barang" value="{{$data->merek}}">
                    <div class="invalid-feedback error-merek"></div>
                </div>
                <div class="form-group">
                    <label for="spesifikasi">Spesifikasi Barang</label>
                    <textarea class="form-control" name="spesifikasi" id="spesifikasi" placeholder="masukkan spesifikasi barang">{{$data->spesifikasi}}</textarea>
                    <div class="invalid-feedback error-spesifikasi"></div>
                </div>
                {{-- <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="text" class="form-control" name="tahun" id="tahun" placeholder="masukkan tahun" value="{{$data->tahun}}">
                    <div class="invalid-feedback error-tahun"></div>
                </div> --}}
                {{-- <div class="form-group">
                    <label for="jumlah-rusak">Jumlah Rusak</label>
                    <input type="text" class="form-control" name="jumlah_rusak" id="jumlah-rusak" placeholder="masukkan jumlah rusak" value="{{$data->jumlah_barang_rusak}}">
                    <div class="invalid-feedback error-jumlah-rusak"></div>
                </div>
                <div class="form-group">
                    <label for="total">Total Barang</label>
                    <input type="text" class="form-control" name="total" id="total" placeholder="masukkan total barang" value="{{$data->total_barang}}">
                    <div class="invalid-feedback error-total"></div>
                </div> --}}
                <div class="form-group pull-right">
                    <button class="btn btn-success btn-update" type="button">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>