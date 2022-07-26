@extends('templates.master')

@section('pwd', 'Laporan')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row printableArea">
    <div class="col-md-12">
        <h3 style="text-align: center">
            <b>Laporan Data Pegawai</b>
        </h3>
        <div class="pull-right text-end">
            <address>
                <p class="m-t-30">
                    <img src="{{asset('assets/images/logo.jpeg')}}" height="100">
                </p>
                <p class="m-t-30">
                    <b>Dicetak oleh :</b>
                    <i class="fa fa-user"></i> {{nama()}}
                </p>
                <p class="m-t-30">
                    <b>Tanggal Laporan :</b>
                    <i class="fa fa-calendar"></i> {{date('d-m-Y')}}
                </p>
            </address>
        </div>
    </div>
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered text-nowrap border-bottom dataTable no-footer" role="grid">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Ruangan</th>
                            <th>TTL</th>
                            <th>No. Telp</th>
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->nip}}</td>
                                <td>{{$data->nama_pegawai}}</td>
                                <td>{{$data->jabatan}}</td>
                                <td>{{$data->ruangan}}</td>
                                <td>{{$data->tempat_lahir}}, {{convertDate($data->tanggal_lahir)}}</td>
                                <td>{{$data->no_telp}}</td>
                                <td>{{$data->alamat}}</td>
                                <td>{{$data->jenis_kelamin}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

