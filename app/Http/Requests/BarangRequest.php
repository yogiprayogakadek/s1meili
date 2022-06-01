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
            'spesifikasi' => 'required',
            'keterangan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute sudah tersedia',
        ];
    }

    public function attributes()
    {
        return [
            'nama' => 'Nama barang',
            'kode' => 'Kode barang',
            'spesifikasi' => 'Spesifikasi barang',
            'keterangan' => 'Keterangan barang',
        ];
    }
}

