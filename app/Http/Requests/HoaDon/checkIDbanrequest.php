<?php

namespace App\Http\Requests\HoaDon;

use Illuminate\Foundation\Http\FormRequest;

class checkIDbanrequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
           'id_ban' =>'required|exists:bans,id'
        ];
    }

    public function messages()
    {
        return [
            'id_ban.*' =>'Bàn Không Tồn Tại',
         ];
    }
}
