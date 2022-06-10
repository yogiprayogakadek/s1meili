<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\PerbaikanRequest;
use App\Models\Perbaikan;
use App\Models\PerbaikanHistori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerbaikanController extends Controller
{
    public function index()
    {
        return view('main.perbaikan.index');
    }

    public function render()
    {
        $data = Perbaikan::with('user')->get();

        $view = [
            'data' => view('main.perbaikan.render', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function create()
    {
        $view = [
            'data' => view('main.perbaikan.create')->render()
        ];

        return response()->json($view);
    }

    public function store(PerbaikanRequest $request)
    {
        try {
            $response = [];
            DB::transaction(function () use ($request, &$response) {
                $dataPerbaikan = [
                    'id_user' => auth()->user()->id_user,
                    'tanggal_perbaikan' => $request->tanggal_perbaikan,
                    'nomor_laporan' => $request->nomor_laporan,
                    'pemohon' => $request->pemohon,
                    'jabatan_pemohon' => $request->jabatan_pemohon,
                ];

                $cekPerbaikan = Perbaikan::where('nomor_laporan', $request->nomor_laporan)->first();
                if($cekPerbaikan) {
                    $response['status'] = 'error';
                    $response['message'] = 'Nomor Laporan sudah tersedia';
                    $response['title'] = 'Gagal Menambah Data';
                } else {
                    $itemPerbaikan = array();
                    for($i = 0; $i < count($request->nama); $i++) {
                        $itemPerbaikan[] = [
                            'id' => $i+1,
                            'nama_barang' => $request->nama[$i],
                            'spesifikasi_barang' => $request->spesifikasi[$i],
                            'uraian' => $request->uraian[$i],
                            'keterangan' => $request->keterangan[$i],
                        ];
                    }

                    $dataPerbaikan['item_perbaikan'] = json_encode($itemPerbaikan);

                    $perbaikan = Perbaikan::create($dataPerbaikan);

                    // insert ke tabel perbaikan_history
                    PerbaikanHistori::create([
                        'id_perbaikan' => $perbaikan->id_perbaikan,
                    ]);
                }
            });

            if(count($response) > 0) {
                return response()->json($response);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil Menambahkan Perbaikan',
                    'title' => 'Berhasil'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => 'Data gagal tersimpan',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }

    public function edit($id)
    {
        $data = Perbaikan::find($id);
        $view = [
            'data' => view('main.perbaikan.edit')->with([
                'data' => $data,
                'item_perbaikan' => json_decode($data->item_perbaikan, true)
            ])->render()
        ];

        return response()->json($view);
    }

    public function update(PerbaikanRequest $request)
    {
        try {
            $perbaikan = Perbaikan::find($request->id_perbaikan);
            $item_perbaikan = array();
            DB::transaction(function () use ($request, $perbaikan, &$item_perbaikan) {
                $dataPerbaikan = [
                    'id_user' => auth()->user()->id_user,
                    'tanggal_perbaikan' => $request->tanggal_perbaikan,
                    'nomor_laporan' => $request->nomor_laporan,
                    'pemohon' => $request->pemohon,
                    'jabatan_pemohon' => $request->jabatan_pemohon,
                ];

                for($i = 0; $i < count($request->nama); $i++) {
                    $item_perbaikan[] = [
                        'id' => $i,
                        'nama_barang' => $request->nama[$i],
                        'spesifikasi_barang' => $request->spesifikasi[$i],
                        'uraian' => $request->uraian[$i],
                        'keterangan' => $request->keterangan[$i],
                    ];
                }
                $dataPerbaikan['item_perbaikan'] = json_encode($item_perbaikan);

                $perbaikan->update($dataPerbaikan);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Mengubah Perbaikan',
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

    public function delete($id)
    {
        try {
            $perbaikan = Perbaikan::find($id);
            $perbaikan->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Menghapus Perbaikan',
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

    public function itemPerbaikan($id)
    {
        $perbaikan = Perbaikan::find($id);
        $item_perbaikan = json_decode($perbaikan->item_perbaikan, true);

        $data = [];
        foreach($item_perbaikan as $key => $item) {
            $data[] = [
                'id' => $key,
                'nama_barang' => $item['nama_barang'],
                'spesifikasi_barang' => $item['spesifikasi_barang'],
                'uraian' => $item['uraian'],
                'keterangan' => $item['keterangan'],
            ];
        }

        return response()->json($data);
    }

    public function validasi(Request $request)
    {
        try {
            // DB::transaction(function () use ($request) {
                $perbaikan = Perbaikan::where('id_perbaikan', $request->id_perbaikan)->first();
                $jabatan = Auth::user()->role->nama;
                $dataTerakhir = PerbaikanHistori::where('id_perbaikan', $request->id_perbaikan)->first();
                $data = [
                    'id_perbaikan' => $request->id_perbaikan,
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
                // $PerbaikanHistori = PerbaikanHistori::where('id_perbaikan', $request->id_perbaikan)->first();
                if($dataTerakhir) {
                    PerbaikanHistori::where('id_perbaikan', $request->id_perbaikan)->update($data);
                    $PerbaikanHistori = PerbaikanHistori::where('id_perbaikan', $request->id_perbaikan)->first();
                    if($PerbaikanHistori->approve_kepala_sekolah == 'Diterima' && $PerbaikanHistori->approve_wakil_sarpras == 'Diterima') {
                        $updatePerbaikan = Perbaikan::where('id_perbaikan', $request->id_perbaikan)->update([
                            'status_perbaikan' => 'Diterima'
                        ]);

                        $PerbaikanHistori->update([
                            'keterangan' => null
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Ditolak' && $PerbaikanHistori->approve_wakil_sarpras == 'Diterima') {
                        $updatePerbaikan = Perbaikan::where('id_perbaikan', $request->id_perbaikan)->update([
                            'status_perbaikan' => 'Ditolak'
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Diterima' && $PerbaikanHistori->approve_wakil_sarpras == 'Ditolak') {
                        $updatePerbaikan = Perbaikan::where('id_perbaikan', $request->id_perbaikan)->update([
                            'status_perbaikan' => 'Ditolak'
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Ditolak' && $PerbaikanHistori->approve_wakil_sarpras == 'Ditolak') {
                        $updatePerbaikan = Perbaikan::where('id_perbaikan', $request->id_perbaikan)->update([
                            'status_perbaikan' => 'Ditolak'
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Diproses' && $PerbaikanHistori->approve_wakil_sarpras == 'Diterima') {
                        $updatePerbaikan = Perbaikan::where('id_perbaikan', $request->id_perbaikan)->update([
                            'status_perbaikan' => 'Diproses'
                        ]);
                        $PerbaikanHistori->update([
                            'keterangan' => null
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Diproses' && $PerbaikanHistori->approve_wakil_sarpras == 'Ditolak') {
                        $updatePerbaikan = Perbaikan::where('id_perbaikan', $request->id_perbaikan)->update([
                            'status_perbaikan' => 'Ditolak'
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Diterima' && $PerbaikanHistori->approve_wakil_sarpras == 'Diproses') {
                        $updatePerbaikan = Perbaikan::where('id_perbaikan', $request->id_perbaikan)->update([
                            'status_perbaikan' => 'Diproses'
                        ]);
                        $PerbaikanHistori->update([
                            'keterangan' => null
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Ditolak' && $PerbaikanHistori->approve_wakil_sarpras == 'Diproses') {
                        $updatePerbaikan = Perbaikan::where('id_perbaikan', $request->id_perbaikan)->update([
                            'status_perbaikan' => 'Ditolak'
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Diproses' && $PerbaikanHistori->approve_wakil_sarpras == 'Diproses') {
                        $updatePerbaikan = Perbaikan::where('id_perbaikan', $request->id_perbaikan)->update([
                            'status_perbaikan' => 'Diproses'
                        ]);
                        $PerbaikanHistori->update([
                            'keterangan' => null
                        ]);
                    }
                } else {
                    PerbaikanHistori::create($data);
                }
                // PerbaikanHistori::create($data);

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

    public function detailValidasi($id_perbaikan)
    {
        $data = PerbaikanHistori::where('id_perbaikan', $id_perbaikan)->first();

        return response()->json($data);
    }
}
