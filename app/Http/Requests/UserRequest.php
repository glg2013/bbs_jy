<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
            //'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),
            'name' => 'required|between:3,25|alpha_dash|unique:users,name,' . Auth::id(),
            'email' => 'required|email',
            'introduction' => 'max:80',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写',
            'name.alpha_dash' => '用户名只能包含字母、数字、破折号和下划线',
            'name.between' => '用户名长度不能小于3个字符或大于25个字符',
            'name.required' => '用户名不能为空',
        ];
    }
}
