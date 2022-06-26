<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\BarangRequest;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        return view('main.barang.index');
    }

    public function render()
    {
        $data = Barang::all();

        $view = [
            'data' => view('main.barang.render', compact('data'))->render()
        ];

        return response()->json($view);
    }
    
    public function print()
    {
        $data = Barang::all();

        $view = [
            'data' => view('main.barang.print', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function create()
    {
        $view = [
            'data' => view('main.barang.create')->render()
        ];

        return response()->json($view);
    }

    public function store(BarangRequest $request)
    {
        try {
            Barang::create([
                'nama_barang' => $request->nama,
                'kode_barang' => $request->kode,
                'merek' => $request->merek,
                'spesifikasi' => $request->spesifikasi,
                // 'tahun' => $request->tahun,
                // 'jumlah_barang_rusak' => $request->jumlah_rusak,
                // 'total_barang' => $request->total,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil tersimpan',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal tersimpan',
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
                // 'tahun' => $request->tahun,
                // 'jumlah_barang_rusak' => $request->jumlah_rusak,
                // 'total_barang' => $request->total,
                'spesifikasi' => $request->spesifikasi,
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

    public function detailBarang($id) {
        $barang = Barang::find($id);
        return response()->json($barang);
    }

    public function dataBarang()
    {
        $barang = Barang::pluck('nama_barang', 'id_barang')->prepend('Pilih Barang', 0);
        return response()->json($barang);
    }
}
