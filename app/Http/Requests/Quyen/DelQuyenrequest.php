<?php

namespace App\Http\Requests\Quyen;

use Illuminate\Foundation\Http\FormRequest;

class DelQuyenrequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
           'id' =>'exists:quyens,id'
        ];
    }
    public function messages()
    {
        return [
            'id.*' =>'Quyền Không Tồn tại'
         ];
    }
}
