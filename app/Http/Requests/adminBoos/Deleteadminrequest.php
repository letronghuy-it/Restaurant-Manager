<?php

namespace App\Http\Requests\adminBoos;

use Illuminate\Foundation\Http\FormRequest;

class Deleteadminrequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'    => 'exists:admins,id',
        ];
    }
    public function messages()
    {
        return [
            'id.*'   => 'Tài khoản ADMIN không tồn tại!',

        ];
    }
}
