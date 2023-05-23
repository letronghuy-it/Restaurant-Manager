<?php

namespace App\Http\Requests\KhachHang;

use Illuminate\Foundation\Http\FormRequest;

class updateKhachHangRequest extends FormRequest
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
            'id'                    =>'required|exists:khach_hangs,id',
            'ma_khach_hang'         =>'required|unique:khach_hangs,ma_khach_hang,'.$this->id,
            'so_dien_thoai'         =>'required|numeric',
            'email'                 =>'required|min:10',
            'ghi_chu'               =>'required|min:0',
            'id_loai_khach'         =>'required|exists:loai_khach_hangs,id',
            'ngay_sinh'             =>'required|date',
            'ma_so_thue'            =>'required|min:5',
        ];
    }

    public function messages()
    {
        return[
            'id.*'              =>'Khách Hàng Không Tồn Tại',
            'ma_khach_hang.*'     =>'Mã Khách hàng Đã Tồn Tại',
            'so_dien_thoai.*'     =>'Yêu Cầu Phải Nhập Đúng Số Điện Thoại',
            'email.*'             =>'email Phải Trên 5 kí Tự',
            'ghi_chu.*'           =>'Hãy Nhập Ghi Chú',
            'id_loai_khach.*'     =>'Loại Khách Hàng Không Tồn Tại Trong Hệ Thống',
            'ngay_sinh.*'         =>'Hãy Nhập Đúng Ngày Sinh ',
            'ma_so_thue.*'        =>'Yếu Cầu Phải Trên 5 kí tự',
        ];
    }
}
