<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserPost extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
             'name'=>'required|unique:user|max:20|min:3',
             'age'=>'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'用户名不能为空',
            'name.unique'=>'用户名已存在',
            'name.max'=>'用户名最多20位',
            'name.min'=>'用户名最少3位',
            'age.required'=>'年龄不能为空',
            'age.integer'=>'年龄必须为整数',
        
        ];
    }
}
