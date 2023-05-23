<?php

namespace App\Http\Requests\HoaDon;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChiTietHoaDonrequest extends FormRequest
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
            'id'              => 'required|exists:chi_tiet_hoa_dons,id',
            'so_luong_ban'    => 'required|numeric',
            'tien_chiet_khau' => 'required|numeric',
            'ghi_chu'         => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'id.*'              =>    'Hoá Đơn Bán Hàng Không Tồn Tại',
            'so_luong_ban.*'    =>    'Số Lượng Bán Không Tồn Tại',
            'tien_chiet_khau.*' =>    'Tiền Chiết Khấu Không Tồn Tại',
            'ghi_chu.*'         =>    'nullable'
        ];
    }


}
