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
                    <input type="hidden" name="id_pegawai" id="id_pegawai" value="{{$data->id_pegawai}}">
                    <label for="nama">Nama Pegawai</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="masukkan nama pegawai" value="{{$data->nama_pegawai}}">
                    <div class="invalid-feedback error-nama"></div>
                </div>
                <div class="form-group">
                    <label for="nip">NIP Pegawai</label>
                    <input type="text" class="form-control" name="nip" id="nip" placeholder="masukkan nip pegawai" value="{{$data->nip}}">
                    <div class="invalid-feedback error-nip"></div>
                </div>
                <div class="form-group">
                    <label for="ruangan">Ruangan Pegawai</label>
                    <input type="text" class="form-control" name="ruangan" id="ruangan" placeholder="masukkan ruangan pegawai" value="{{$data->ruangan}}">
                    <div class="invalid-feedback error-ruangan"></div>
                </div>
                <div class="form-group">
                    <label for="jabatan">Jabatan Pegawai</label>
                    <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="masukkan jabatan pegawai" value="{{$data->jabatan}}">
                    <div class="invalid-feedback error-jabatan"></div>
                </div>
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <textarea class="form-control" name="tempat_lahir" id="tempat_lahir" rows="4" placeholder="masukkan tempat lahir">{{$data->tempat_lahir}}</textarea>
                    <div class="invalid-feedback error-tempat_lahir"></div>
                </div>
                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" placeholder="masukkan tanggal lahir" value="{{$data->tanggal_lahir}}">
                    <div class="invalid-feedback error-tanggal_lahir"></div>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                        <option value="">Pilih jenis kelamin</option>
                        <option value="Laki-Laki" {{$data->jenis_kelamin === 'Laki-Laki' ? 'selected' : ''}}>Laki-Laki</option>
                        <option value="Perempuan" {{$data->jenis_kelamin === 'Perempuan' ? 'selected' : ''}}>Perempuan</option>
                    </select>
                    <div class="invalid-feedback error-jenis_kelamin"></div>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" name="alamat" id="alamat" rows="4" placeholder="masukkan tempat lahir">{{$data->alamat}}</textarea>
                    <div class="invalid-feedback error-alamat"></div>
                </div>
                <div class="form-group">
                    <label for="no_telp">No HP</label>
                    <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="masukkan no hp" value="{{$data->no_telp}}">
                    <div class="invalid-feedback error-no_telp"></div>
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control" name="foto" id="foto" placeholder="masukkan foto">
                    <span class="text-muted text-small">*kosongkan jika tidak ada foto</span>
                    <div class="invalid-feedback error-foto"></div>
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