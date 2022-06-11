<?php

use App\Models\Maintenance;
use App\Models\MaintenanceHistori;
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
    if(auth()->user()->role->nama == 'Kepala Sekolah') {
        $total = PengadaanHistori::where('approve_kepala_sekolah', '!=', 'Diterima')->count();
    } else {
        $total = PengadaanHistori::where('approve_wakil_sarpras', '!=', 'Diterima')->count();
    }

    return $total;
}

function maintenanceNeedApproval($kategori)
{
    $data = Maintenance::where('kategori_maintenance', $kategori)->first();
    $total = 0;
    if ($data) {
        if(auth()->user()->role->nama == 'Kepala Sekolah') {
            $total = MaintenanceHistori::where('id_maintenance', $data->id_maintenance)->where('approve_kepala_sekolah', '!=', 'Diterima')->orWhere('approve_kepala_sekolah', null)->count();
        } else {
            $total = MaintenanceHistori::where('id_maintenance', $data->id_maintenance)->where('approve_wakil_sarpras', '!=', 'Diterima')->orWhere('approve_wakil_sarpras', null)->count();
        }
    } 

    return $total;
}