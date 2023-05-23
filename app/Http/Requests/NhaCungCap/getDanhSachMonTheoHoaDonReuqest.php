<?php

namespace App\Http\Requests\NhaCungCap;

use Illuminate\Foundation\Http\FormRequest;

class getDanhSachMonTheoHoaDonReuqest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id_hoa_don_nhap_hang' => 'required|exists:hoa_don_nhaps,id'
        ];
    }

    public function messages()
    {
        return [
            'id_hoa_don_nhap_hang.*' => 'Hoá Đơn Nhập Không Tồn Tại!'
        ];
    }
}
