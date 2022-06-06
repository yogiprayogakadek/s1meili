<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Pengadaan;
use App\Models\PengadaanHistori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengadaanHistoriController extends Controller
{
    public function index()
    {
        return view('main.pengadaan-histori.index');
    }

    public function render()
    {
        $data = Pengadaan::with(['user', 'pengadaan_histori' => function ($query) {
            $query->whereIn('approve_kepala_sekolah', ['Diterima', 'Diproses', 'Ditolak'])
                ->orWhereIn('approve_wakil_sarpras', ['Diterima', 'Diproses', 'Ditolak']);
        }])->get();
        $view = [
            'data' => view('main.pengadaan-histori.render', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function validasi(Request $request)
    {
        try {
            // dd($request->all());
            $jabatan = Auth::user()->role->nama;
            $dataTerakhir = PengadaanHistori::where('id_pengadaan', $request->id_pengadaan)->first();
            // $userValidasi = '';

            // $jabatan == 'Kepala Sekolah' ? $userValidasi = 'approve_kepala_sekolah' : $userValidasi = 'approve_wakil_sarpras';
            
            // if(PengadaanHistori::count() > 0) {
            //     if($dataTerakhir->$userValidasi == $request->status) {
            //         return response()->json([
            //             'status' => 'error',
            //             'message' => 'Data sudah pernah di validasi',
            //             'title' => 'Gagal'
            //         ]);
            //     } 
            // }

            $data = [
                'id_pengadaan' => $request->id_pengadaan,
            ];

            if ($request->status == 'Ditolak') {
                $data['keterangan'] = $request->keterangan;
            }

            if($jabatan == 'Kepala Sekolah') {
                $data['approve_kepala_sekolah'] = $request->status;
                $data['tanggal_approve_kepala_sekolah'] = date('Y-m-d H:i:s');
            } else {
                $data['approve_wakil_sarpras'] = $request->status;
                $data['tanggal_approve_wakil_sarpras'] = date('Y-m-d H:i:s');
            }

            if($dataTerakhir) {
                // if($dataTerakhir->approve_kepala_sekolah == 'Diterima' && $dataTerakhir->approve_wakil_sarpras == 'Diterima') {
                //     $data['keterangan'] = null;
                // }
                PengadaanHistori::where('id_pengadaan', $request->id_pengadaan)->update($data);
            } else {
                PengadaanHistori::create($data);
            }
            // PengadaanHistori::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil di validasi',
                'title' => 'Berhasil'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => 'Data gagal tersimpan',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }

    public function detailValidasi($id_pengadaan)
    {
        $data = PengadaanHistori::where('id_pengadaan', $id_pengadaan)->first();

        return response()->json($data);
    }
}
