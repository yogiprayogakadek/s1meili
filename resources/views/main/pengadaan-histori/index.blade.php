@extends('templates.master')

@section('title', 'Pengadaan Barang')
@section('pwd', 'Pengadaan Barang')
@section('sub-pwd', 'Data')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="row render">
    {{--  --}}
</div>
@endsection

@push('script')
    <script src="{{asset('functions/pengadaan-histori/main.js')}}"></script>
@endpush