<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengadaanRequest;
use App\Models\Barang;
use App\Models\ItemPengadaan;
use App\Models\Pengadaan;
use App\Models\PengadaanHistori;
use Illuminate\Http\Request;
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

        $view = [
            'data' => view('main.pengadaan.render', compact('data'))->render()
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
        $barang = Barang::pluck('nama_barang', 'id_barang')->toArray();
        $view = [
            'data' => view('main.pengadaan.create')->with([
                'barang' => $barang
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
                    'tanggal_penerimaan' => $request->tanggal_penerimaan,
                    'nomor_laporan' => $request->nomor_laporan,
                    'biaya_pengadaan' => preg_replace('/[^0-9]/', '', $request->biaya),
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
    
                    $request->file('nota')->move($save_path, $filenametostore);
                }
                $cekPengadaan = Pengadaan::where('nomor_laporan', $request->nomor_laporan)->first();
                if($cekPengadaan) {
                    $response['status'] = 'error';
                    $response['message'] = 'Nomor Laporan sudah ada';
                    $response['title'] = 'Gagal Menambahkan Pengadaan';
                } 
                else {
                    $pengadaan = Pengadaan::create($dataPengadaan);

                    for($i = 0; $i < count($request->nama); $i++) {
                        $cek = Barang::where('nama_barang', $request->nama[$i])->first();
                        $dataBarang[] = [
                            'nama_barang' => $request->nama[$i],
                            'merek' => $request->merek[$i],
                            'kode_barang' => randomString(),
                            // 'kode_barang' => $request->kode[$i],
                        ];

                        if(!$cek) {
                            $barang = Barang::create($dataBarang[$i]);
                            ItemPengadaan::create([
                                'id_pengadaan' => $pengadaan->id_pengadaan,
                                'id_barang' => $barang->id_barang,
                                'jumlah_barang' => $request->jumlah[$i],
                            ]);
                        } else {
                            ItemPengadaan::create([
                                'id_pengadaan' => $pengadaan->id_pengadaan,
                                'id_barang' => $cek->id_barang,
                                'jumlah_barang' => $request->jumlah[$i],
                            ]);
                        }
                    }
                }
            });
            // dd(count($response));
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
        $data = Barang::find($id);
        $view = [
            'data' => view('main.barang.edit', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function update(PengadaanRequest $request, Barang $kategori)
    {
        try {
            $barang = Barang::find($request->id);
            $barang->update([
                'nama_barang' => $request->nama,
                'kode_barang' => $request->kode,
                'merek' => $request->merek,
                'tahun' => $request->tahun,
                'jumlah_barang_rusak' => $request->jumlah_rusak,
                'total_barang' => $request->total,
            ]);

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
}
