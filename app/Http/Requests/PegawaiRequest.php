<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PegawaiRequest extends FormRequest
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
            'nip' => 'required',
            'nama' => 'required',
            'jabatan' => 'required',
            'no_telp' => 'required|numeric',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'tempat_lahir' => 'required',
            'ruangan' => 'required',
        ];

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
            'nip' => 'NIP',
            'nama' => 'Nama',
            'jabatan' => 'Jabatan',
            'no_telp' => 'No. Telp',
            'alamat' => 'Alamat',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tanggal_lahir' => 'Tanggal Lahir',
            'tempat_lahir' => 'Tempat Lahir',
            'ruangan' => 'Ruangan',
        ];
        return $attr;
    }
}
