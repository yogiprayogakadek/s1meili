@extends('templates.master')

@section('pwd', 'Laporan')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row printableArea">
    <div class="col-md-12">
        <h3 style="text-align: center">
            <b>Laporan Data Pengadaan</b>
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
                            <th>Nama Pemohon</th>
                            <th>Tanggal Pengadaan</th>
                            <th>Nomor Laporan</th>
                            <th>Biaya Pengadaan</th>
                            {{-- <th>Keterangan</th> --}}
                            <th>Status Pengadaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data->pegawai->nama_pegawai}}</td>
                                <td>{{$data->tanggal_pengadaan}}</td>
                                <td>{{$data->nomor_laporan}}</td>
                                <td>{{convertToRupiah($data->biaya_pengadaan)}}</td>
                                @if ($data->status_pengadaan != 'Dibatalkan')
                                    <td>{{$data->status_pengadaan}}</td>
                                @else
                                    {{-- <td>{{$data->status_pengadaan}}</td> --}}
                                    <td>
                                        {{$data->status_pengadaan}} <br><br>
                                        <span>Dibatalkan oleh: {{json_decode($data->pembatalan, true)['nama_pembatal']}}</span><br>
                                        <span>Tanggal Pembatalan: {{json_decode($data->pembatalan, true)['tanggal_pembatalan']}}</span><br>
                                        <span>Keterangan: {{json_decode($data->pembatalan, true)['keterangan']}}</span>
                                        
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

