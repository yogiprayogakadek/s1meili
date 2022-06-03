<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengadaanRequest;
use App\Models\Barang;
use App\Models\ItemPengadaan;
use App\Models\Pengadaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanController extends Controller
{
    public function index()
    {
        return view('main.pengadaan.index');
    }

    public function render()
    {
        $data = Pengadaan::with('barang', 'user')->get();

        $view = [
            'data' => view('main.pengadaan.render', compact('data'))->render()
        ];

        return response()->json($view);
    }
    
    public function print()
    {
        $data = Pengadaan::with('barang', 'user')->get();

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
            DB::transaction(function () use ($request) {
                $dataPengadaan = [
                    'id_user' => auth()->user()->id,
                    'tanggal_pengadaan' => $request->tanggal_pengadaan,
                    'tanggal_penerimaan' => $request->tanggal_penerimaan,
                    'nomor_laporan' => $request->nomor_laporan,
                    'biaya_pengadaan' => preg_replace('/[^0-9]/', '', $request->biaya_pengadaan),
                ];

                if($request->hasFile('nota')) {
                    $filenamewithextension = $request->file('nota')->getClientOriginalName();
                    $extension = $request->file('nota')->getClientOriginalExtension();
    
                    $filenametostore = $request->nomor_laporan. '-'. time() .'.'.$extension;
                    $save_path = 'assets/uploads/pengadaan/';
    
                    if(!file_exists($save_path)) {
                        mkdir($save_path, 666, true);
                    }
    
                    $dataPengadaan[] = [
                        'nota' => $save_path . $filenametostore,
                    ];
    
                    $request->file('nota')->move($save_path, $filenametostore);
                }

                for($i = 0; $i < count($request->nama); $i++) {
                    $dataBarang[] = [
                        'id_barang' => $request->id_barang[$i],
                        'nama_barang' => $request->nama[$i],
                        'merek' => $request->merek[$i],
                        'kode_barang' => $request->kode[$i],
                    ];

                    $dataPengadaanBarang[] = [
                        'id_pengadaan' => Pengadaan::create($dataPengadaan)->id_pengadaan,
                        'id_barang' => $request->id_barang[$i],
                        'jumlah_barang' => $request->jumlah[$i],
                        // 'merek' => $request->merek[$i],
                        // 'kode' => $request->kode[$i],
                    ];

                    ItemPengadaan::create($dataPengadaanBarang);
                }
    
                // Pengadaan::create($data);
            });
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil tersimpan',
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

    public function edit($id)
    {
        $data = Barang::find($id);
        $view = [
            'data' => view('main.barang.edit', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function update(BarangRequest $request, Barang $kategori)
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
            Barang::find($id)->delete();

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
