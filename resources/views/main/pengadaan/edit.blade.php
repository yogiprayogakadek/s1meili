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
                {{-- <div class="row">
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
                </div> --}}

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
                {{-- <div class="form-group">
                    <label for="tanggal-penerimaan">Tanggal Penerimaan</label>
                    <input type="date" class="form-control tanggal_penerimaan" name="tanggal_penerimaan" id="tanggal-penerimaan" placeholder="masukkan tanggal penerimaan barang" value="{{$data->tanggal_penerimaan}}">
                    <div class="invalid-feedback error-tanggal_penerimaan"></div>
                </div> --}}
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
            @for ($i = 0; $i < count($data->item_pengadaan); $i++)
            <div class="card">
                <div class="card-header">Item Barang</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <select name="nama[{{$i}}]" id="nama{{$i}}" class="form-control nama{{$i}} nama-barang" data-id="{{$i}}">
                            @foreach ($barang as $key => $value)
                            <option value="{{$key}}" {{$data->item_pengadaan[$i]->id_barang == $key ? 'selected' : ''}}>{{$value}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback error-nama0"></div>
                    </div>
                    <div class="form-group">
                        <label for="merek">Merek Barang</label>
                        <input type="text" class="form-control merek0" name="merek[{{$i}}]" id="merek{{$i}}" readonly value="{{$data->item_pengadaan[$i]->barang->merek}}">
                        <div class="invalid-feedback error-merek{{$i}}"></div>
                    </div>
                    <div class="form-group">
                        <label for="spesifikasi">Spesifikasi Barang</label>
                        <textarea class="form-control spesifikasi{{$i}}" name="spesifikasi[{{$i}}]" id="spesifikasi{{$i}}" readonly>{{$data->item_pengadaan[$i]->barang->spesifikasi}}</textarea>
                        <div class="invalid-feedback error-spesifikasi{{$i}}"></div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Barang</label>
                        <input type="number" class="form-control jumlah{{$i}}" name="jumlah[{{$i}}]" id="jumlah{{$i}}" placeholder="masukkan jumlah barang" value="{{$data->item_pengadaan[$i]->jumlah_barang}}">
                        <div class="invalid-feedback error-jumlah{{$i}}"></div>
                    </div>
                    <div class="form-group">
                        <label for="satuan">Satuan Barang</label>
                        <input type="text" class="form-control satuan{{$i}}" name="satuan[{{$i}}]" id="satuan{{$i}}" placeholder="masukkan satuan barang" value="{{$data->item_pengadaan[$i]->satuan_barang}}">
                        <div class="invalid-feedback error-satuan{{$i}}"></div>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga Satuan</label>
                        <input type="text" class="form-control harga-satuan harga{{$i}}" name="harga[{{$i}}]" id="harga{{$i}}" data-harga="harga{{$i}}" placeholder="masukkan harga satuan barang" value="{{convertToRupiah($data->item_pengadaan[$i]->harga_satuan)}}">
                        <div class="invalid-feedback error-harga{{$i}}"></div>
                    </div>
                </div>
            </div>
            @endfor

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