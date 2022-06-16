@extends('templates.master')

@section('title', 'Perawatan Barang')
@section('pwd', 'Perawatan Barang')
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
    <script src="{{asset('functions/perawatan/main.js')}}"></script>
@endpush