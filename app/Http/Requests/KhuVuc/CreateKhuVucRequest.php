<?php

namespace App\Http\Requests\KhuVuc;

use Illuminate\Foundation\Http\FormRequest;

class CreateKhuVucRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'ten_khu_vuc'  =>'required|min:5|max:30',
            'slug_khu_vuc'  =>'required|min:5|unique:khu_vucs,slug_khu_vuc',
            'tinh_trang'  =>'required|boolean',
        ];
    }
    public function messages()
    {
        return[
            'ten_khu_vuc.required'  =>'Yêu Cầu Phải Nhập Tên Khu Vực',
            'ten_khu_vuc.min'       =>'Tên Khu Vực Phải Trên 5 Ký Tự',
            'ten_khu_vuc.max'       =>'Tên Khu Vực Tối Dưới 30 Kí Tự',
            'slug_khu_vuc.min'      =>'Slug Khu Vực tối đa phải 5 kí Tự',
            'slug_khu_vuc.required' =>'Yêu Cầu Phải Nhật Slug Khu Vực',
            'slug_khu_vuc.unique'   =>'Khu Vực này đã tồn tại',
            'tinh_trang.*'          =>'Vui Lòng Nhập Tình Trạng',
        ];

    }
}
