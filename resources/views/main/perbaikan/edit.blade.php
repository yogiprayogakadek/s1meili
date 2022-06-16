<div class="col-12">
    <form id="formEdit">
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
                            <input type="hidden" value="{{$data->id_maintenance}}" name="id_maintenance">
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
                </div> --}}

                <input type="hidden" value="{{$data->id_maintenance}}" name="id_maintenance">
                <div class="form-group">
                    <label for="pemohon">Nama Pemohon</label>
                    <select name="pemohon" id="pemohon" class="form-control pemohon">
                        @foreach ($pegawai as $key => $value)
                        <option value="{{$key}}" {{$key == $data->id_pegawai ? 'selected' : ''}}>{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback error-pemohon"></div>
                </div>

                <div class="form-group">
                    <label for="nomor-laporan">Nomor Laporan</label>
                    <input type="text" class="form-control nomor_laporan" name="nomor_laporan" id="nomor-laporan" placeholder="masukkan nomor laporan" value="{{$data->nomor_laporan}}">
                    <div class="invalid-feedback error-nomor_laporan"></div>
                </div>
                <div class="form-group">
                    <label for="tanggal-maintenance">Tanggal Perbaikan</label>
                    <input type="date" class="form-control tanggal_maintenance" name="tanggal_maintenance" id="tanggal-maintenance" placeholder="masukkan tanggal perbaikan barang" value="{{$data->tanggal_maintenance}}">
                    <div class="invalid-feedback error-tanggal_maintenance"></div>
                </div>
                <div class="form-group">
                    <label for="biaya">Biaya</label>
                    <input type="text" class="form-control biaya" name="biaya" id="biaya" placeholder="masukkan biaya" value="{{convertToRupiah($data->biaya_maintenance)}}">
                    <div class="invalid-feedback error-biaya"></div>
                </div>
                {{-- </form> --}}
            </div>
        </div>
        <div id="item-barang">
            @foreach ($item_perbaikan as $item)
            {{-- {{$item}} --}}
            <div class="card">
                <div class="card-header">Item Barang</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" class="form-control nama{{$item['id']}}" name="nama[{{$item['id']}}]" id="nama{{$item['id']}}" placeholder="masukkan nama barang" value="{{$item['nama_barang']}}">
                        <div class="invalid-feedback error-nama{{$item['id']}}"></div>
                    </div>
                    <div class="form-group">
                        <label for="spesifikasi">Spesifikasi Barang</label>
                        <textarea class="form-control spesifikasi{{$item['id']}}" name="spesifikasi[{{$item['id']}}]" id="spesifikasi{{$item['id']}}" placeholder="masukkan spesifikasi barang">{{$item['spesifikasi_barang']}}</textarea>
                        <div class="invalid-feedback error-spesifikasi{{$item['id']}}"></div>
                    </div>
                    <div class="form-group">
                        <label for="uraian">Uraian Perbaikan Barang</label>
                        <textarea class="form-control uraian{{$item['id']}}" name="uraian[{{$item['id']}}]" id="uraian{{$item['id']}}" placeholder="masukkan uraian barang">{{$item['uraian']}}</textarea>
                        <div class="invalid-feedback error-uraian{{$item['id']}}"></div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan Perbaikan</label>
                        <textarea class="form-control keterangan{{$item['id']}}" name="keterangan[{{$item['id']}}]" id="keterangan{{$item['id']}}" placeholder="masukkan keterangan barang">{{$item['keterangan']}}</textarea>
                        <div class="invalid-feedback error-keterangan{{$item['id']}}"></div>
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