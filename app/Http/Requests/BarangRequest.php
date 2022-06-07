<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
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
        return [
            'nama' => 'required',
            'kode' => 'required',
            'merek' => 'required',
            // 'tahun' => 'required|numeric',
            // 'jumlah_rusak' => 'required|numeric',
            // 'total' => 'required|numeric',
            'spesifikasi' => 'required',
        ];
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
        return [
            'nama' => 'Nama barang',
            'kode' => 'Kode barang',
            'merek' => 'Merek barang',
            // 'tahun' => 'Tahun barang',
            // 'jumlah_rusak' => 'Jumlah barang rusak',
            // 'total' => 'Total barang',
            'spesifikasi' => 'Spesifikasi barang',
        ];
    }
}

