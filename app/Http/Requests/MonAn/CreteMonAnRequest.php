<?php

namespace App\Http\Requests\MonAn;

use Illuminate\Foundation\Http\FormRequest;

class CreteMonAnRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'ten_mon_an'        => 'required|min:5|max:30',
            'slug_mon_an'       => 'required|min:5|unique:mon_ans,slug_mon_an',
            'gia_ban'           => 'required|numeric|min:0',
            'tinh_trang'        => 'required|boolean',
            'id_danh_muc'       => 'required|exists:danh_mucs,id',
            'hinh_anh'          =>  'required|mimes:png,jpg',

        ];
    }

    public function messages()
    {
        return [
            'ten_mon_an.required'   => 'yêu Cầu Phải Nhập Tên Món',
            'ten_mon_an.min'        => 'Yêu Cầu Phải Nhập Tên Món ít nhất 5',
            'ten_mon_an.max'        => 'kí tự và tối đa 30 kí tự',
            'slug_mon_an.*'         => 'Slug Món Đã Tồn Tại!',
            'gia_ban.*'             => 'Giá Bán ít Nhất là 0 Đ',
            'tinh_trang.*'          => 'Vui Lòng Chọn Tình Trạng ',
            'id_danh_muc.*'         => 'Danh Mục g Hệ Thống',
        ];
    }
}
