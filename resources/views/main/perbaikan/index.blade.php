@extends('templates.master')

@section('title', 'Perbaikan Barang')
@section('pwd', 'Perbaikan Barang')
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
    <script src="{{asset('functions/perbaikan/main.js')}}"></script>
@endpush