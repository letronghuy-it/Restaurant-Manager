<?php

namespace App\Http\Requests\LoaiKhachHang;

use Illuminate\Foundation\Http\FormRequest;

class updateLoaiKhachHangRequest extends FormRequest
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
            'id'                =>'required|exists:loai_khach_hangs,id',
            'ten_loai_khach'    =>'required|min:5|unique:loai_khach_hangs,ten_loai_khach,'.$this->id,
            'phan_tram_giam'    =>'required|numeric|min:0|max:100',
            'list_mon_tang'     =>'required|min:5',
        ];
    }

    public function messages()
    {
        return [
            'id.*'              =>'Loại Khách Hàng Không Tồn Tại',
            'ten_loai_khach.*'  =>'Vui Lòng Nhập Đầy Đủ Họ Và Tên',
            'phan_tram_giam.*'  =>'Phần trăm Giảm Giá Phải Là số Tối Thiểu từ 0% đến 100%',
            'list_mon_tang.*'   =>'Vui Lòng Nhập List Món tặng Nếu Không Có Nhập Từ : Không Có ',
        ];
    }
}
