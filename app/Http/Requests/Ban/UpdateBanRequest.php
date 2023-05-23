<?php

namespace App\Http\Requests\Ban;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBanRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'             =>'required|exists:bans,id',
            'ten_ban'        => 'required|min:5|max:30',
            'slug_ban'       => 'required|min:5|unique:bans,slug_ban,'.$this->id,
            'id_khu_vuc'     => 'required|exists:khu_vucs,id',
            'gia_mo_ban'     => 'required|numeric|min:0',
            'tien_gio'       => 'required|numeric|min:0',
            'tinh_trang'     => 'required|boolean',
        ];
    }

    public function messages()
    {
        return[
            'id.*'               =>'Bàn Không Tồn Tại',
            'ten_ban.required'   =>'Yêu Cầu Phải Nhập tên Món',
            'ten_ban.min'        =>'Tên món tối đa phải 5 kí Tự',
            'slug_ban.min'       =>'Slug món tối đa phải 5 kí Tự',
            'slug_ban.required'  =>'Yêu cầu phải nhập slug món',
            'slug_ban.unique'    =>'Món ăn này đã tồn tại',
            'ten_ban.max'        =>'Tên Món Chỉ tối thiểu 30 Kí Tự',
            'id_khu_vuc.*'       =>'Khu Vực Không Tồn Tại Trong Hệ Thống',
            'gia_mo_ban.*'       =>'Giá Mở Bàn Phải ít Nhất 0Đ',
            'tien_gio.*'         =>'Tiền Giờ giải ít Nhất 0Đ',
            'tinh_trang.*'       =>'Vui Lòng Chọn Tình Trạng',
        ];
    }
}
