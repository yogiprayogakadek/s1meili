@extends('templates.master')

@section('title', 'Barang')
@section('pwd', 'Barang')
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
    <script src="{{asset('functions/barang/main.js')}}"></script>
@endpush