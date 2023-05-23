<?php

namespace App\Http\Requests\DanhMuc;

use Illuminate\Foundation\Http\FormRequest;

class CreateDanhMucRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'ten_danh_muc' =>'required|min:5|max:30',
            'slug_danh_muc' =>'required|unique:danh_mucs,slug_danh_muc',
            'tinh_trang'    =>'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'ten_danh_muc.required'  =>'Vui Lòng Nhập Tên Danh Mục',
            'ten_danh_muc.min'       =>'Tên Danh Mục Thiểu Trên 5 Kí Tự',
            'ten_danh_muc.max'       =>'Tên Danh Mục Tối Đa Trên 30 Kí Tự',
            'slug_danh_muc.required' =>'Yêu cầu phải nhập slug Danh Mục',
            'slug_danh_muc.unique'   =>'Danh Mục này đã tồn tại',
            'tinh_trang.*'           =>'Vui Lòng Nhập Tình Trạng',
        ];
    }
}
