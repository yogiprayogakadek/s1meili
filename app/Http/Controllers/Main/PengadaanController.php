<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengadaanRequest;
use App\Models\Barang;
use App\Models\ItemPengadaan;
use App\Models\Maintenance;
use App\Models\Pegawai;
use App\Models\Pengadaan;
use App\Models\PengadaanHistori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengadaanController extends Controller
{
    public function index()
    {
        return view('main.pengadaan.index');
    }

    public function render()
    {
        $data = Pengadaan::with('user')->get();
        $pegawai = Pegawai::pluck('nama_pegawai', 'id_pegawai')->prepend('Pilih Pegawai', '');

        $view = [
            'data' => view('main.pengadaan.render', compact('data', 'pegawai'))->render()
        ];

        return response()->json($view);
    }
    
    public function print()
    {
        $data = Pengadaan::with('user')->get();

        $view = [
            'data' => view('main.pengadaan.print', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function create()
    {
        $pegawai = Pegawai::pluck('nama_pegawai', 'id_pegawai')->prepend('Pilih Pegawai', '');
        $barang = Barang::pluck('nama_barang', 'id_barang')->toArray();
        $view = [
            'data' => view('main.pengadaan.create')->with([
                'barang' => $barang,
                'pegawai' => $pegawai
            ])->render()
        ];

        return response()->json($view);
    }

    public function store(PengadaanRequest $request)
    {
        try {
            $response = [];
            DB::transaction(function () use ($request, &$response) {
                $dataPengadaan = [
                    'id_user' => auth()->user()->id_user,
                    'tanggal_pengadaan' => $request->tanggal_pengadaan,
                    // 'tanggal_penerimaan' => $request->tanggal_penerimaan,
                    'nomor_laporan' => $request->nomor_laporan,
                    'biaya_pengadaan' => preg_replace('/[^0-9]/', '', $request->biaya),
                    'keterangan' => $request->keterangan,
                    'id_pegawai' => $request->pemohon
                    // 'pemohon' => $request->pemohon,
                    // 'jabatan_pemohon' => $request->jabatan_pemohon,
                ];

                $cekPengadaan = Pengadaan::where('nomor_laporan', $request->nomor_laporan)->first();
                if($cekPengadaan) {
                    $response['status'] = 'error';
                    $response['message'] = 'Nomor Laporan sudah ada';
                    $response['title'] = 'Gagal Menambahkan Pengadaan';
                } 
                else {
                    $pengadaan = Pengadaan::create($dataPengadaan);

                    // insert ke tabel pengadaan_histori
                    PengadaanHistori::create([
                        'id_pengadaan' => $pengadaan->id_pengadaan,
                    ]);

                    for($i = 0; $i < count($request->nama); $i++) {
                        $cek = Barang::where('nama_barang', $request->nama[$i])->first();
                        $dataBarang[] = [
                            'nama_barang' => $request->nama[$i],
                            'merek' => $request->merek[$i],
                            'kode_barang' => randomString(),
                            'spesifikasi' => $request->spesifikasi[$i],
                            // 'kode_barang' => $request->kode[$i],
                        ];

                        if(!$cek) {
                            $barang = Barang::create($dataBarang[$i]);
                            ItemPengadaan::create([
                                'id_pengadaan' => $pengadaan->id_pengadaan,
                                'id_barang' => $barang->id_barang,
                                'harga_satuan' => preg_replace('/[^0-9]/', '', $request->harga[$i]),
                                'jumlah_barang' => $request->jumlah[$i],
                            ]);
                        } else {
                            ItemPengadaan::create([
                                'id_pengadaan' => $pengadaan->id_pengadaan,
                                'id_barang' => $cek->id_barang,
                                'harga_satuan' => preg_replace('/[^0-9]/', '', $request->harga[$i]),
                                'jumlah_barang' => $request->jumlah[$i],
                            ]);
                        }
                    }
                }
            });
            if(count($response) > 0) {
                return response()->json($response);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil Menambahkan Pengadaan',
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
        $data = Pengadaan::with('item_pengadaan.barang')->find($id);
        $view = [
            'data' => view('main.pengadaan.edit', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function update(PengadaanRequest $request)
    {
        try {
            $pengadaan = Pengadaan::find($request->id_pengadaan);
            DB::transaction(function () use ($request, $pengadaan) {
                $dataPengadaan = [
                    'id_user' => auth()->user()->id_user,
                    'tanggal_pengadaan' => $request->tanggal_pengadaan,
                    // 'tanggal_penerimaan' => $request->tanggal_penerimaan,
                    'nomor_laporan' => $request->nomor_laporan,
                    'biaya_pengadaan' => preg_replace('/[^0-9]/', '', $request->biaya),
                    'keterangan' => $request->keterangan,
                    'id_pegawai' => $request->pemohon
                    // 'pemohon' => $request->pemohon,
                    // 'jabatan_pemohon' => $request->jabatan_pemohon,
                ];

                if($request->hasFile('nota')) {
                    
                    $filenamewithextension = $request->file('nota')->getClientOriginalName();
                    $extension = $request->file('nota')->getClientOriginalExtension();
    
                    $filenametostore = $request->nomor_laporan. '-'. time() .'.'.$extension;
                    $save_path = 'assets/uploads/pengadaan/nota/';
    
                    if(!file_exists($save_path)) {
                        mkdir($save_path, 666, true);
                    }
    
                    $dataPengadaan['nota'] = $save_path . $filenametostore;
                    if($pengadaan->nota != null) {
                        unlink($pengadaan->nota);
                    }
                    $request->file('nota')->move($save_path, $filenametostore);
                }

                $pengadaan->update($dataPengadaan);
                if($pengadaan->status_pengadaan == 'Diterima') {
                    // dd('masuk');
                    $item_pengadaan = ItemPengadaan::where('id_pengadaan', $pengadaan->id_pengadaan)->get();
                    foreach($item_pengadaan as $item) {
                        $barang = Barang::find($item->id_barang);
                        if($barang) {
                            $barang->update([
                                'total_barang' => $barang->total_barang - $item->jumlah_barang,
                            ]);
                        }
                    }
                }

                // Delete Item Pengadaan
                ItemPengadaan::where('id_pengadaan', $pengadaan->id_pengadaan)->delete();

                // insert ke tabel item_pengadaan
                for($i = 0; $i < count($request->nama); $i++) {
                    $cek = Barang::where('nama_barang', $request->nama[$i])->first();
                    $dataBarang[] = [
                        'nama_barang' => $request->nama[$i],
                        'merek' => $request->merek[$i],
                        'kode_barang' => randomString(),
                        'spesifikasi' => $request->spesifikasi[$i],
                    ];

                    if(!$cek) {
                        if($pengadaan->status_pengadaan == 'Diterima') {
                            $dataBarang[$i]['total_barang'] = $request->jumlah[$i];
                        }
                        $barang = Barang::create($dataBarang[$i]);
                        ItemPengadaan::create([
                            'id_pengadaan' => $pengadaan->id_pengadaan,
                            'id_barang' => $barang->id_barang,
                            'harga_satuan' => preg_replace('/[^0-9]/', '', $request->harga[$i]),
                            'jumlah_barang' => $request->jumlah[$i],
                        ]);
                    } else {
                        $barang = Barang::where('id_barang', $cek->id_barang)->first();
                        $barang->update([
                            'total_barang' => $barang->total_barang + $request->jumlah[$i],
                        ]);
                        ItemPengadaan::create([
                            'id_pengadaan' => $pengadaan->id_pengadaan,
                            'id_barang' => $cek->id_barang,
                            'harga_satuan' => preg_replace('/[^0-9]/', '', $request->harga[$i]),
                            'jumlah_barang' => $request->jumlah[$i],
                        ]);
                    }
                }
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil tersimpan',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal diubah',
                'title' => 'Gagal'
            ]);
        }
    }

    public function itemPengadaan($id_pengadaan) {
        $itemPengadaan = ItemPengadaan::with('barang')->where('id_pengadaan', $id_pengadaan)->get();
        $pengadaan = Pengadaan::find($id_pengadaan);
        $penerima = json_decode($pengadaan->penerimaan, true);
        $data = [];
        foreach($itemPengadaan as $key => $item) {
            $data[] = [
                'no' => $key + 1,
                'nama_barang' => $item->barang->nama_barang,
                'harga_satuan' => convertToRupiah($item->harga_satuan),
                'jumlah_barang' => $item->jumlah_barang,
                'total' => convertToRupiah($item->harga_satuan * $item->jumlah_barang)
            ];
        }

        return response()->json([
            'user_login' => auth()->user()->role->nama,
            'data' => $data,
            'nama_penerima' => $penerima['nama_penerima'] ?? 'Belum diterima',
            'tanggal_penerimaan' => $penerima['tanggal_penerimaan'] ?? '-',
        ]);
    }

    public function delete($id)
    {
        try {
            Pengadaan::find($id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal dihapus',
                'title' => 'Gagal'
            ]);
        }
    }

    public function validasi(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
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
                                // 'jumlah_barang_rusak' => $barang->jumlah_barang_rusak
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
                                    // 'jumlah_barang_rusak' => $barang->jumlah_barang_rusak
                                ]);
                            }
                        }
                    }
                    
                } else {
                    PengadaanHistori::create($data);
                }
                // PengadaanHistori::create($data);

            });
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

    public function unggahNota(Request $request)
    {
        try {
            $data = Pengadaan::where('id_pengadaan', $request->id_pengadaan)->first();
            if($request->hasFile('nota')) {
                if($data->nota != null) {
                    unlink($data->nota);
                }
                $filenamewithextension = $request->file('nota')->getClientOriginalName();
                $extension = $request->file('nota')->getClientOriginalExtension();

                $filenametostore = $request->nomor_laporan. '-'. time() .'.'.$extension;
                $save_path = 'assets/uploads/pengadaan/nota/';

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
            $pengadaan = Pengadaan::find($request->id_pengadaan);

            $penerimaan = [
                'nama_penerima' => Pegawai::where('id_pegawai', $request->id_pegawai)->first()->nama_pegawai,
                'tanggal_penerimaan' => $request->tanggal
            ];

            $pengadaan->update([
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
