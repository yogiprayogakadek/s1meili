<?php

use App\Models\Maintenance;
use App\Models\MaintenanceHistori;
use App\Models\Pengadaan;
use App\Models\PengadaanHistori;
use Illuminate\Http\Request;

function randomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function convertDate($date, $printDate = false)
{
    //explode / pecah tanggal berdasarkan tanda "-"
    $exp = explode("-", $date);

    $day = array(
        1 =>    'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    );

    $month = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    // return $exp[2] . ' ' . $month[(int)$exp[1]] . ' ' . $exp[0];

    $split       = explode('-', $date);
    $convertDate = $split[2] . ' ' . $month[(int)$split[1]] . ' ' . $split[0];

    if ($printDate) {
        $num = date('N', strtotime($date));
        return $day[$num] . ', ' . $convertDate;
    }
    return $convertDate;
}

function convertToRupiah($jumlah)
{
    return 'Rp' . number_format($jumlah, 0, '.', '.');
}
function fotoAkun()
{
    return asset(auth()->user()->foto);
}

function nama()
{
    return auth()->user()->nama;
}

function subtractingDate($date1, $date2)
{
    $datetime1 = strtotime($date1);
    $datetime2 = strtotime($date2);

    $secs = $datetime2 - $datetime1;// == <seconds between the two times>
    $days = $secs / 86400;
    return $days;
}

function pengadaanNeedApproval()
{
    if(auth()->user()->role->nama === 'Kepala Sekolah') {
        $total = PengadaanHistori::where('approve_kepala_sekolah', null)->count();
    } elseif(auth()->user()->role->nama === 'Wakil Sarpras') {
        $total = PengadaanHistori::where('approve_wakil_sarpras', null)->count();
    } elseif(auth()->user()->role->nama === 'Staf Administrasi') {
        $total = Pengadaan::withCount(['pengadaan_histori' => function ($query) {
            $query->where('approve_kepala_sekolah', 'Diterima')->where('approve_wakil_sarpras', 'Diterima');
        }])->where('penerimaan', null)->count();
    }

    return $total;
}

function pengadaanNeedApprovalBendahara()
{
    if(auth()->user()->role->nama === 'Bendahara') {
        $total = Pengadaan::where('status_pengadaan', 'Diterima')->where('nota', null)->count();
    }

    return $total;
}

function maintenanceNeedApproval($kategori)
{
    $data = Maintenance::where('kategori_maintenance', $kategori)->where('status_maintenance', 'Diproses')->get();
    $total = 0;

    foreach ($data as $key => $value) {
        // $total++;
        if(auth()->user()->role->nama === 'Kepala Sekolah') {
            // $total++;
            $value->maintenance_histori()->where('approve_kepala_sekolah', null)->orWhere('approve_kepala_sekolah', '!=', 'Diterima')->count() > 0 ? $total++ : null;
        } elseif(auth()->user()->role->nama === 'Wakil Sarpras') {
            // $total++;
            $value->maintenance_histori()->where('approve_wakil_sarpras', null)->orWhere('approve_wakil_sarpras', '!=', 'Diterima')->count() > 0 ? $total++ : null;
        }
    }
    return $total;
}

function maintenaceNeedApproveBendahara($kategori)
{
    $data = Maintenance::where('kategori_maintenance', $kategori)->where('status_maintenance', 'Diterima')->where('nota', null)->count();
    return $data;
}

function menu()
{
    $menu = [
        'Barang', 'Pengadaan', 'Perbaikan', 'Kerusakan', 'Perawatan'
    ];

    return $menu;
}

function kategoriPengeluaran()
{
    $menu = [
        'Pengadaan', 'Perbaikan', 'Kerusakan', 'Perawatan'
    ];

    return $menu;
}

function totalPengeluaran($kategori)
{
    $total = 0;
    if($kategori == 'Pengadaan') {
        $data = Pengadaan::where('status_pengadaan', 'Diterima')->get();
        foreach ($data as $key => $value) {
            $total += $value->biaya_pengadaan;
        }
    } else {
        $data = Maintenance::where('status_maintenance', 'Diterima')->get();
        foreach ($data as $key => $value) {
            $total += $value->biaya_maintenance;
        }
    }
    
    return convertToRupiah($total);
}

function RouteURL()
{
    $url = [
        0 => 'barang.index', 
        1 => 'pengadaan.index', 
        2 => 'perbaikan.index', 
        3 => 'kerusakan.index',
        4 => 'perawatan.index'
    ];

    return $url;
}

function totalData($model)
{
    $a = 'App\Models\\' . $model;
    if($model == 'Perbaikan'){
        $total = Maintenance::where('kategori_maintenance', 'Perbaikan')->count();
    }
    elseif($model == 'Perawatan'){
        $total = Maintenance::where('kategori_maintenance', 'Perawatan')->count();
    }
    elseif($model == 'Kerusakan'){
        $total = Maintenance::where('kategori_maintenance', 'Kerusakan')->count();
    }
    else{
        $total = $a::count();
    }
    return $total;
}

function bulan()
{
    $bulan = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    return $bulan;
}
