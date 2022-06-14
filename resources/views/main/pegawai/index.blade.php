@extends('templates.master')

@section('title', 'Pegawai')
@section('pwd', 'Pegawai')
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
    <script src="{{asset('functions/pegawai/main.js')}}"></script>
@endpush