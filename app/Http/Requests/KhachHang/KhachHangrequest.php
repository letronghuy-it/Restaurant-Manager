<?php

namespace App\Http\Requests\KhachHang;

use Illuminate\Foundation\Http\FormRequest;

class KhachHangrequest extends FormRequest
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
            'ma_khach_hang'         =>'required|unique:khach_hangs,ma_khach_hang',
            'so_dien_thoai'         =>'required|numeric|min:0',
            'email'                 =>'required|min:10',
            'ghi_chu'               =>'required|min:0',
            'id_loai_khach'        =>'required|exists:loai_khach_hangs,id',
            'ngay_sinh'             =>'required|date',
            'ma_so_thue'            =>'required|min:5',
        ];
    }

    public function messages()
    {
        return[
            'ma_khach_hang.*'     =>'Mã Khách hàng Đã Tồn Tại',
            'so_dien_thoai.*'     =>'Yêu Cầu Phải Nhập Đúng Số Điện Thoại',
            'email.*'             =>'email Phải Trên 10 kí Tự',
            'ghi_chu.*'           =>'Hãy Nhập Ghi Chú',
            'id_loai_khach.*'     =>'Loại Khách Hàng Không Tồn Tại Trong Hệ Thống',
            'ngay_sinh.*'         =>'Hãy Nhập Đúng Ngày Sinh ',
            'ma_so_thue.*'        =>'mã Số Thuê Yếu Cầu Phải Trên 5 kí tự',
        ];
    }
}
