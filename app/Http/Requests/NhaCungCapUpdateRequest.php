<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NhaCungCapUpdateRequest extends FormRequest
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


    public function rules()
    {
        return [
            'id'              => 'required|exists:chi_tiet_hoa_don_nhaps,id',
            'so_luong_nhap'   => 'required|numeric',
            'ghi_chu'         => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'id.*'               =>   'required|exists:chi_tiet_hoa_don_nhaps,id',
            'so_luong_nhap.*'    =>   'required|numeric',
            'ghi_chu.*'          =>   'nullable'
        ];
    }
}
