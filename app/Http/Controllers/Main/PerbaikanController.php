<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceRequest;
use App\Models\Barang;
use App\Models\Maintenance;
use App\Models\MaintenanceHistori;
use App\Models\Pegawai;
use App\Models\Perbaikan;
use App\Models\PerbaikanHistori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerbaikanController extends Controller
{
    protected $kategori_maintenance = 'Perbaikan';
    public function index()
    {
        return view('main.perbaikan.index');
    }

    public function render()
    {
        $data = Maintenance::with('user')->where('kategori_maintenance', $this->kategori_maintenance)->get();
        $pegawai = Pegawai::pluck('nama_pegawai', 'id_pegawai')->prepend('Pilih Pegawai', '');
        $view = [
            'data' => view('main.perbaikan.render', compact('data', 'pegawai'))->render()
        ];

        return response()->json($view);
    }

    public function create()
    {
        $barang = Barang::pluck('nama_barang', 'id_barang')->prepend('Pilih Barang', '');
        $pegawai = Pegawai::pluck('nama_pegawai', 'id_pegawai')->prepend('Pilih Pegawai', '');
        $view = [
            'data' => view('main.perbaikan.create')->with([
                'pegawai' => $pegawai,
                'barang' => $barang,
            ])->render()
        ];

        return response()->json($view);
    }

    public function store(MaintenanceRequest $request)
    {
        try {
            $response = [];
            DB::transaction(function () use ($request, &$response) {
                $dataPerbaikan = [
                    'id_user' => auth()->user()->id_user,
                    'tanggal_maintenance' => $request->tanggal_maintenance,
                    'nomor_laporan' => $request->nomor_laporan,
                    'id_pegawai' => $request->pemohon,
                    // 'pemohon' => $request->pemohon,
                    // 'jabatan_pemohon' => $request->jabatan_pemohon,
                    'kategori_maintenance' => $this->kategori_maintenance,
                    'biaya_maintenance' => preg_replace('/[^0-9]/', '', $request->biaya),
                ];

                // dd($dataPerbaikan);

                $cekPerbaikan = Maintenance::where('nomor_laporan', $request->nomor_laporan)->first();
                if($cekPerbaikan) {
                    $response['status'] = 'error';
                    $response['message'] = 'Nomor Laporan sudah tersedia';
                    $response['title'] = 'Gagal Menambah Data';
                } else {
                    $itemPerbaikan = array();
                    for($i = 0; $i < count($request->nama); $i++) {
                        $itemPerbaikan[] = [
                            'id' => $i+1,
                            'nama_barang' => Barang::find($request->nama[$i])->nama_barang,
                            'spesifikasi_barang' => $request->spesifikasi[$i],
                            'uraian' => $request->uraian[$i],
                            'keterangan' => $request->keterangan[$i],
                        ];
                    }

                    // dd($itemPerbaikan);

                    $dataPerbaikan['item_maintenance'] = json_encode($itemPerbaikan);

                    $perbaikan = Maintenance::create($dataPerbaikan);

                    // insert ke tabel perbaikan_history
                    MaintenanceHistori::create([
                        'id_maintenance' => $perbaikan->id_maintenance,
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
        $data = Maintenance::find($id);
        $barang = Barang::pluck('nama_barang', 'id_barang')->prepend('Pilih Barang', '');
        $pegawai = Pegawai::pluck('nama_pegawai', 'id_pegawai')->prepend('Pilih Pegawai', '');
        $view = [
            'data' => view('main.perbaikan.edit')->with([
                'data' => $data,
                'pegawai' => $pegawai,
                'item_perbaikan' => json_decode($data->item_maintenance, true),
                'barang' => $barang,
            ])->render()
        ];

        return response()->json($view);
    }

    public function update(MaintenanceRequest $request)
    {
        try {
            // dd($request->all());
            $perbaikan = Maintenance::find($request->id_maintenance);
            $item_perbaikan = array();
            DB::transaction(function () use ($request, $perbaikan, &$item_perbaikan) {
                $dataPerbaikan = [
                    'id_user' => auth()->user()->id_user,
                    'tanggal_maintenance' => $request->tanggal_maintenance,
                    'nomor_laporan' => $request->nomor_laporan,
                    'id_pegawai' => $request->pemohon,
                    // 'pemohon' => $request->pemohon,
                    // 'jabatan_pemohon' => $request->jabatan_pemohon,
                    'biaya_maintenance' => preg_replace('/[^0-9]/', '', $request->biaya),
                ];

                for($i = 0; $i < count($request->nama); $i++) {
                    $item_perbaikan[] = [
                        'id' => $i+1,
                        'nama_barang' => Barang::find($request->nama[$i])->nama_barang,
                        'spesifikasi_barang' => $request->spesifikasi[$i],
                        'uraian' => $request->uraian[$i],
                        'keterangan' => $request->keterangan[$i],
                    ];
                }
                $dataPerbaikan['item_maintenance'] = json_encode($item_perbaikan);

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
            $perbaikan = Maintenance::find($id);
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
        $perbaikan = Maintenance::find($id);
        $item_perbaikan = json_decode($perbaikan->item_maintenance, true);
        $penerima = json_decode($perbaikan->penerimaan, true);
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

        return response()->json([
            'user_login' => auth()->user()->role->nama,
            'data' => $data,
            'biaya_perbaikan' => $penerima['biaya_perbaikan'] ?? 'Belum diterima',
            'tanggal_penyelesaian' => $penerima['tanggal_penyelesaian'] ?? '-',
            'uraian_perbaikan' => $penerima['uraian_perbaikan'] ?? '-',
        ]);

        // return response()->json($data);
    }

    public function validasi(Request $request)
    {
        try {
            // dd($request->all());
            // DB::transaction(function () use ($request) {
                $perbaikan = Maintenance::where('id_maintenance', $request->id_maintenance)->first();
                $jabatan = Auth::user()->role->nama;
                $dataTerakhir = MaintenanceHistori::where('id_maintenance', $request->id_maintenance)->first();
                $data = [
                    'id_maintenance' => $request->id_maintenance,
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
                // $PerbaikanHistori = MaintenanceHistori::where('id_maintenance', $request->id_maintenance)->first();
                if($dataTerakhir) {
                    MaintenanceHistori::where('id_maintenance', $request->id_maintenance)->update($data);
                    $PerbaikanHistori = MaintenanceHistori::where('id_maintenance', $request->id_maintenance)->first();
                    if($PerbaikanHistori->approve_kepala_sekolah == 'Diterima' && $PerbaikanHistori->approve_wakil_sarpras == 'Diterima') {
                        $updatePerbaikan = Maintenance::where('id_maintenance', $request->id_maintenance)->update([
                            'status_maintenance' => 'Diterima'
                        ]);

                        $PerbaikanHistori->update([
                            'keterangan' => null
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Ditolak' && $PerbaikanHistori->approve_wakil_sarpras == 'Diterima') {
                        $updatePerbaikan = Maintenance::where('id_maintenance', $request->id_maintenance)->update([
                            'status_maintenance' => 'Ditolak'
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Diterima' && $PerbaikanHistori->approve_wakil_sarpras == 'Ditolak') {
                        $updatePerbaikan = Maintenance::where('id_maintenance', $request->id_maintenance)->update([
                            'status_maintenance' => 'Ditolak'
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Ditolak' && $PerbaikanHistori->approve_wakil_sarpras == 'Ditolak') {
                        $updatePerbaikan = Maintenance::where('id_maintenance', $request->id_maintenance)->update([
                            'status_maintenance' => 'Ditolak'
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Diproses' && $PerbaikanHistori->approve_wakil_sarpras == 'Diterima') {
                        $updatePerbaikan = Maintenance::where('id_maintenance', $request->id_maintenance)->update([
                            'status_maintenance' => 'Diproses'
                        ]);
                        $PerbaikanHistori->update([
                            'keterangan' => null
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Diproses' && $PerbaikanHistori->approve_wakil_sarpras == 'Ditolak') {
                        $updatePerbaikan = Maintenance::where('id_maintenance', $request->id_maintenance)->update([
                            'status_maintenance' => 'Ditolak'
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Diterima' && $PerbaikanHistori->approve_wakil_sarpras == 'Diproses') {
                        $updatePerbaikan = Maintenance::where('id_maintenance', $request->id_maintenance)->update([
                            'status_maintenance' => 'Diproses'
                        ]);
                        $PerbaikanHistori->update([
                            'keterangan' => null
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Ditolak' && $PerbaikanHistori->approve_wakil_sarpras == 'Diproses') {
                        $updatePerbaikan = Maintenance::where('id_maintenance', $request->id_maintenance)->update([
                            'status_maintenance' => 'Ditolak'
                        ]);
                    } else if($PerbaikanHistori->approve_kepala_sekolah == 'Diproses' && $PerbaikanHistori->approve_wakil_sarpras == 'Diproses') {
                        $updatePerbaikan = Maintenance::where('id_maintenance', $request->id_maintenance)->update([
                            'status_maintenance' => 'Diproses'
                        ]);
                        $PerbaikanHistori->update([
                            'keterangan' => null
                        ]);
                    }
                } else {
                    MaintenanceHistori::create($data);
                }
                // MaintenanceHistori::create($data);

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

    public function detailValidasi($id_maintenance)
    {
        $data = MaintenanceHistori::where('id_maintenance', $id_maintenance)->first();

        return response()->json($data);
    }

    public function unggahNota(Request $request)
    {
        try {
            $data = Maintenance::where('id_maintenance', $request->id_maintenance)->first();
            // dd($request->id_maintenance);
            if($request->hasFile('nota')) {
                if($data->nota != null) {
                    unlink($data->nota);
                }
                $filenamewithextension = $request->file('nota')->getClientOriginalName();
                $extension = $request->file('nota')->getClientOriginalExtension();

                $filenametostore = $request->nomor_laporan. '-'. time() .'.'.$extension;
                $save_path = 'assets/uploads/perbaikan/nota/';

                if(!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $request->file('nota')->move($save_path, $filenametostore);

                $data->update([
                    'nota' => $save_path . $filenametostore
                ]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Nota berhasil diunggah',
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

    public function prosesPenerimaan(Request $request)
    {
        try {
            $maintenance = Maintenance::find($request->id_maintenance);

            $penerimaan = [
                // 'nama_penerima' => Pegawai::where('id_pegawai', $request->id_pegawai)->first()->nama_pegawai,
                'tanggal_penyelesaian' => $request->tanggal,
                'uraian_perbaikan' => $request->uraian,
                'biaya_perbaikan' => preg_replace('/[^0-9]/', '', $request->biaya),
            ];

            $maintenance->update([
                'penerimaan' => json_encode($penerimaan),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diproses',
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
}
