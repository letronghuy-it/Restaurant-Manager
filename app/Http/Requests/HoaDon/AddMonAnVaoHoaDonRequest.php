<?php

namespace App\Http\Requests\HoaDon;

use Illuminate\Foundation\Http\FormRequest;

class AddMonAnVaoHoaDonRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'id_mon'                =>'required|exists:mon_ans,id',
            'id_hoa_don_ban_hang'   =>'required|exists:hoa_don_ban_hangs,id',
        ];
    }

    public function messages()
    {
        return [
            'id_mon.*'                =>'Món Ăn Không Tồn Tại!',
            'id_hoa_don_ban_hang.*'   =>'Hoá Đơn Bán Hàng Không Tồn Tai!',
        ];
    }
}
