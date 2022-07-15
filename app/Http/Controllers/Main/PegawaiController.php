<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiRequest;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        return view('main.pegawai.index');
    }

    public function render()
    {
        $data = Pegawai::all();

        $view = [
            'data' => view('main.pegawai.render', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function create()
    {
        $view = [
            'data' => view('main.pegawai.create')->render()
        ];

        return response()->json($view);
    }

    public function store(PegawaiRequest $request)
    {
        try {
            $data = [
                'nip' => $request->nip,
                'nama_pegawai' => $request->nama,
                'jabatan' => $request->jabatan,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'ruangan' => $request->ruangan,
            ];

            if ($request->hasFile('foto')) {
                $filenamewithextension = $request->file('foto')->getClientOriginalName();
                $extension = $request->file('foto')->getClientOriginalExtension();

                $filenametostore = $request->nama. '-'. time() .'.'.$extension;
                $save_path = 'assets/uploads/pegawai/';

                if(!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $request->file('foto')->move($save_path, $filenametostore);

                $data['foto'] = $save_path . $filenametostore;
            } else {
                $data['foto'] = 'assets/uploads/users/default.png';
            }

            Pegawai::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Menambahkan Data Pegawai',
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
        $data = Pegawai::find($id);

        $view = [
            'data' => view('main.pegawai.edit', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function update(PegawaiRequest $request)
    {
        try {
            $pegawai = Pegawai::find($request->id_pegawai);
            $data = [
                'nip' => $request->nip,
                'nama_pegawai' => $request->nama,
                'jabatan' => $request->jabatan,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'ruangan' => $request->ruangan,
            ];

            if ($request->hasFile('foto')) {
                if ($pegawai->foto != 'assets/uploads/users/default.png') {
                    unlink($pegawai->foto);
                }
                $filenamewithextension = $request->file('foto')->getClientOriginalName();
                $extension = $request->file('foto')->getClientOriginalExtension();

                $filenametostore = $request->nama. '-'. time() .'.'.$extension;
                $save_path = 'assets/uploads/pegawai/';

                if(!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $request->file('foto')->move($save_path, $filenametostore);

                $data['foto'] = $save_path . $filenametostore;
            }

            $pegawai->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Mengubah Data Pegawai',
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
            $pegawai = Pegawai::find($id);
            if ($pegawai->foto != 'assets/uploads/users/default.png') {
                unlink($pegawai->foto);
            }
            $pegawai->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Menghapus Data Pegawai',
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

    public function changeStatus(Request $request)
    {
        try {
            $status = $request->status;
            $id_pegawai = $request->id_pegawai;
            $pegawai = Pegawai::find($id_pegawai);
            $pegawai->update([
                'status' => $status
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Status berhasil di ubah',
                'title' => 'Berhasil'
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Status gagal di ubah',
                'title' => 'Gagal'
            ]);
        }
    }
}
