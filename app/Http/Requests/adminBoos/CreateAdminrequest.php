<?php

namespace App\Http\Requests\adminBoos;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminrequest extends FormRequest
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
            'ho_va_ten'         =>  'required|min:5',
            'email'             =>  'required|email|unique:admins,email',
            'so_dien_thoai'     =>  'required|digits:10',
            'ngay_sinh'         =>  'required|date',
            'password'          =>  'required',
            're_password'       =>  'required|same:password',

        ];
    }

    public function messages()
    {
        return [
            'ho_va_ten.*'         =>  'Họ và tên không được để trống!',
            'email.required'      =>  'Email không được để trống!',
            'email.email'         =>  'Email không đúng định dạng!',
            'email.unique'        =>  'Email đã tồn tại trong hệ thống!',
            'so_dien_thoai.*'     =>  'Số điện thoại phải là 10 số!',
            'ngay_sinh.*'         =>  'Ngày sinh không được để trống!',
            'password.*'          =>  'Mật khẩu không được để trống!',
            're_password.*'       =>  'Mật khẩu không trùng khớp!',
        ];
    }
}
