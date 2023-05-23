<?php

namespace App\Http\Requests\HoaDon;

use Illuminate\Foundation\Http\FormRequest;

class GetDanhSachMonTheoHoaDonRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'id_hoa_don_ban_hang'   =>'required|exists:hoa_don_ban_hangs,id',
        ];
    }

    public function messages()
    {
        return[
            'id_hoa_don_ban_hang.*' =>'Hoá Đơn Bán Hàng Không Tồn Tại!',
        ];
    }
}
