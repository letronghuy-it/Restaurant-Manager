<?php

namespace App\Http\Requests\NhaCungCap;

use Illuminate\Foundation\Http\FormRequest;

class CreateNhaCungCapRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'ma_so_thue'            =>'required|unique:nha_cung_caps,ma_so_thue',
            'ten_cong_ty'           =>'required|unique:nha_cung_caps,ten_cong_ty',
            'ten_nguoi_dai_dien'    =>'required|min:5',
            'so_dien_thoai'         =>'required|numeric|min:0',
            'email'                 =>'required|min:0',
            'dia_chi'               =>'required|min:0',
            'ten_goi_nho'           =>'required|min:0',
            'tinh_trang'            =>'required|boolean',
        ];
    }

    public function messages()
    {
        return[
            'ma_so_thue.*'                   =>'Vui Lòng Phải Nhập Mã Số Thuế',
            'ten_cong_ty.*'                  =>'Vui Lòng Nhập Tên Công Ty',
            'ten_nguoi_dai_dien.*'           =>'Tên Người Đại Diện Ít Nhất 5 Kí Tự',
            'so_dien_thoai.*'                =>'Yêu Cầu Nhập Đúng Số Điện Thoại ',
            'email.*'                        =>'Nhập email Đàng Quàng Đi Nào!!',
            'dia_chi.*'                      =>'Nhập Địa Chỉ Đang Quàng Đi Nào',
            'ten_goi_nho.*'                  =>'Nhập Đà Quàng Đi Trên 5 kí Tự Giúp Tao',
            'tinh_trang.*'                   =>'Chưa Nhập Tình Trạng Kìa Chú',
        ];
    }
}
