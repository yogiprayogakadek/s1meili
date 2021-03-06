<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceRequest extends FormRequest
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
            'tanggal_maintenance' => 'required',
            'nomor_laporan' => 'required',
            'pemohon' => 'required',
            'jabatan_pemohon' => 'required',
            'biaya' => 'required',
        ];

        for($i = 1; $i <= count($this->input('nama')); $i++) {
            $rules['nama.' . $i] = 'required';
            $rules['spesifikasi.' . $i] = 'required';
            $rules['uraian.' . $i] = 'required';
            $rules['keterangan.' . $i] = 'required';
        }

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
            'tanggal_maintenance' => 'Tanggal Perbaikan',
            'nomor_laporan' => 'Nomor Laporan',
            'pemohon' => 'Pemohon',
            'jabatan_pemohon' => 'Jabatan',
            'biaya' => 'Biaya',
        ];

        for($i = 1; $i <= count($this->input('nama')); $i++) {
            $attr['nama.' . $i] = 'Nama Barang';
            $attr['spesifikasi.' . $i] = 'Spesifikasi Barang';
            $attr['uraian.' . $i] = 'Uraian Barang';
            $attr['keterangan.' . $i] = 'Keterangan Barang';
        }
        return $attr;
    }
}