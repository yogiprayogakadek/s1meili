<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengadaanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'tanggal_pengadaan' => 'required',
            // 'tanggal_penerimaan' => 'required',
            'nomor_laporan' => 'required',
            'biaya' => 'required',
            // 'keterangan' => 'required',
            // 'pemohon' => 'required',
            // 'jabatan_pemohon' => 'required',
        ];

        for($i = 0; $i < count($this->input('nama')); $i++) {
            $rules['nama.' . $i] = 'required';
            $rules['jumlah.' . $i] = 'required';
            $rules['merek.' . $i] = 'required';
            $rules['spesifikasi.' . $i] = 'required';
            $rules['harga.' . $i] = 'required';
            // $rules['kode.' .$i] = 'required';
        }

        // foreach($this->request->get('nama') as $key => $value) {
        //     $rules['kode.' . $key] = 'required';
        //     $rules['nama.' . $key] = 'required';
        //     $rules['jumlah.' . $key] = 'required|numeric';
        //     $rules['merek.' . $key] = 'required';
        // }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute sudah tersedia',
            'numeric' => ':attribute harus berupa angka',
        ];
    }

    public function attributes()
    {
        $attr = [
            'tanggal_pengadaan' => 'Tanggal Pengadaan',
            'tanggal_penerimaan' => 'Tanggal Penerimaan',
            'nomor_laporan' => 'Nomor Laporan',
            'biaya_pengadaan' => 'Biaya Pengadaan',
            'keterangan' => 'Keterangan',
            'pemohon' => 'Pemohon',
            'jabatan_pemohon' => 'Jabatan',
        ];

        for($i = 0; $i < count($this->input('nama')); $i++) {
            $attr['nama.' . $i] = 'Nama Barang';
            $attr['jumlah.' . $i] = 'Jumlah Barang';
            $attr['merek.' . $i] = 'Merek Barang';
            $attr['spesifikasi.' . $i] = 'Spesifikasi Barang';
            $attr['harga.' . $i] = 'Harga Satuan';
            // $attr['kode.' . $i] = 'Kode Barang';
        }

        // foreach($this->request->get('nama') as $key => $value) {
        //     $attr['kode.' . $key] = 'Kode Barang';
        //     $attr['nama.' . $key] = 'Nama Barang';
        //     $attr['jumlah.' . $key] = 'Jumlah Barang';
        //     $attr['merek.' . $key] = 'Merek Barang';
        // }

        return $attr;
    }
}
