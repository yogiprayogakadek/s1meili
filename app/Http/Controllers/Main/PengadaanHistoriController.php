<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\ItemPengadaan;
use App\Models\Pengadaan;
use App\Models\PengadaanHistori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            // DB::transaction(function () use ($request) {
                $pengadaan = Pengadaan::where('id_pengadaan', $request->id_pengadaan)->first();
                $jabatan = Auth::user()->role->nama;
                $dataTerakhir = PengadaanHistori::where('id_pengadaan', $request->id_pengadaan)->first();
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
                // $pengadaanHistori = PengadaanHistori::where('id_pengadaan', $request->id_pengadaan)->first();
                if($dataTerakhir) {
                    PengadaanHistori::where('id_pengadaan', $request->id_pengadaan)->update($data);
                    $pengadaanHistori = PengadaanHistori::where('id_pengadaan', $request->id_pengadaan)->first();
                    if($pengadaanHistori->approve_kepala_sekolah == 'Diterima' && $pengadaanHistori->approve_wakil_sarpras == 'Diterima') {
                        $updatePengadaan = Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update([
                            'status_pengadaan' => 'Diterima'
                        ]);

                        $pengadaanHistori->update([
                            'keterangan' => null
                        ]);

                        $items = ItemPengadaan::where('id_pengadaan', $request->id_pengadaan)->get();
                        foreach ($items as $item) {
                            $barang = Barang::where('id_barang', $item->id_barang)->first();
                            $barang->update([
                                'total_barang' => $item->jumlah_barang + $barang->total_barang,
                                'jumlah_barang_rusak' => $barang->jumlah_barang_rusak
                            ]);
                        }
                    } else if($pengadaanHistori->approve_kepala_sekolah == 'Ditolak' && $pengadaanHistori->approve_wakil_sarpras == 'Diterima') {
                        $updatePengadaan = Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update([
                            'status_pengadaan' => 'Ditolak'
                        ]);
                    } else if($pengadaanHistori->approve_kepala_sekolah == 'Diterima' && $pengadaanHistori->approve_wakil_sarpras == 'Ditolak') {
                        $updatePengadaan = Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update([
                            'status_pengadaan' => 'Ditolak'
                        ]);
                    } else if($pengadaanHistori->approve_kepala_sekolah == 'Ditolak' && $pengadaanHistori->approve_wakil_sarpras == 'Ditolak') {
                        $updatePengadaan = Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update([
                            'status_pengadaan' => 'Ditolak'
                        ]);
                    } else if($pengadaanHistori->approve_kepala_sekolah == 'Diproses' && $pengadaanHistori->approve_wakil_sarpras == 'Diterima') {
                        $updatePengadaan = Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update([
                            'status_pengadaan' => 'Diproses'
                        ]);
                        $pengadaanHistori->update([
                            'keterangan' => null
                        ]);
                    } else if($pengadaanHistori->approve_kepala_sekolah == 'Diproses' && $pengadaanHistori->approve_wakil_sarpras == 'Ditolak') {
                        $updatePengadaan = Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update([
                            'status_pengadaan' => 'Ditolak'
                        ]);
                    } else if($pengadaanHistori->approve_kepala_sekolah == 'Diterima' && $pengadaanHistori->approve_wakil_sarpras == 'Diproses') {
                        $updatePengadaan = Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update([
                            'status_pengadaan' => 'Diproses'
                        ]);
                        $pengadaanHistori->update([
                            'keterangan' => null
                        ]);
                    } else if($pengadaanHistori->approve_kepala_sekolah == 'Ditolak' && $pengadaanHistori->approve_wakil_sarpras == 'Diproses') {
                        $updatePengadaan = Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update([
                            'status_pengadaan' => 'Ditolak'
                        ]);
                    } else if($pengadaanHistori->approve_kepala_sekolah == 'Diproses' && $pengadaanHistori->approve_wakil_sarpras == 'Diproses') {
                        $updatePengadaan = Pengadaan::where('id_pengadaan', $request->id_pengadaan)->update([
                            'status_pengadaan' => 'Diproses'
                        ]);
                        $pengadaanHistori->update([
                            'keterangan' => null
                        ]);
                    }

                    if($pengadaan->getOriginal('status_pengadaan') == 'Diterima') {
                        // dd('diterima');
                        if($pengadaan->getOriginal('status_pengadaan') != Pengadaan::where('id_pengadaan', $request->id_pengadaan)->first()->status_pengadaan) {
                            // dd('diproses');
                            $items = ItemPengadaan::where('id_pengadaan', $request->id_pengadaan)->get();
                            foreach ($items as $item) {
                                $barang = Barang::where('id_barang', $item->id_barang)->first();
                                $barang->update([
                                    'total_barang' =>  $barang->total_barang - $item->jumlah_barang,
                                    'jumlah_barang_rusak' => $barang->jumlah_barang_rusak
                                ]);
                            }
                        }
                    }
                    
                } else {
                    PengadaanHistori::create($data);
                }
                // PengadaanHistori::create($data);

            // });
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
