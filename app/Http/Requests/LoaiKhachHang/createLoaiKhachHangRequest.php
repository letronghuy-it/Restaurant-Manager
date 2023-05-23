<?php

namespace App\Http\Requests\LoaiKhachHang;

use Illuminate\Foundation\Http\FormRequest;

class createLoaiKhachHangRequest extends FormRequest
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

            'ten_loai_khach'    => 'required|min:5',
            'phan_tram_giam'    => 'required|numeric|min:0|max:100',

        ];
    }

    public function messages()
    {
        return [
            'ten_loai_khach.*'  => 'Vui Lòng Nhập Đầy Đủ Họ Và Tên',
            'phan_tram_giam.*'  => 'Phần trăm Giảm Giá Phải Là số Tối Thiểu từ 0% đến 100%',

        ];
    }
}
