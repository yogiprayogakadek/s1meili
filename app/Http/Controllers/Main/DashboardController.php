<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('main.dashboard.index');
    }

    public function chart(Request $request)
    {
        $chart = array();

        if($request->kategori == 'Pengadaan') {
            $data = DB::table('pengadaan')
                ->select('pengadaan.id_pengadaan', 'pengadaan.tanggal_pengadaan as tanggal', DB::raw('SUM(item_pengadaan.jumlah_barang) as jumlah'))
                ->leftJoin('item_pengadaan', 'item_pengadaan.id_pengadaan', '=', 'pengadaan.id_pengadaan')
                ->where('pengadaan.status_pengadaan', '=', 'Diterima')
                ->whereMonth('pengadaan.tanggal_pengadaan', '=', $request->bulan)
                ->whereYear('pengadaan.tanggal_pengadaan', '=', $request->tahun)
                ->groupBy('pengadaan.tanggal_pengadaan')
                ->get();
        } else {
            $data = DB::table('maintenances')
                ->select('maintenances.id_maintenance', 'maintenances.tanggal_maintenance as tanggal', DB::raw('JSON_LENGTH(maintenances.item_maintenance) as jumlah'))
                ->where('maintenances.kategori_maintenance', '=', $request->kategori)
                ->where('status_maintenance', '=', 'Diterima')
                ->whereMonth('tanggal_maintenance', '=', $request->bulan)
                ->whereYear('tanggal_maintenance', '=', $request->tahun)
                ->get();
        }

        // dd($data);

        foreach ($data as $key => $value) {
            $chart[] = [
                'label' => $value->tanggal,
                'jumlah' => $value->jumlah,
            ];
        }

        $view = [
            'data' => view('main.dashboard.chart.index')->with([
                'bulan' => bulan()[$request->bulan-1],
                'tahun' => $request->tahun,
                'chart' => $chart,
                'totalData' => count($data),
                'kategori' => $request->kategori,
            ])->render()
        ];

        return response()->json($view);
    }
}