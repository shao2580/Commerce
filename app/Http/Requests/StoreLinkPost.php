<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkPost extends FormRequest
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
            'name'=>'required|unique:friend|max:20|min:2',
            'url'=>'required',
        ];
    }
     public function messages()
    {
        return [
            'name.required'=>'用户名不能为空',
            'name.unique'=>'用户名已存在',
            'name.max'=>'用户名最多20位',
            'name.min'=>'用户名最少2位',
            'url.required'=>'网站网址不能为空',
            
        
        ];
    }
}
