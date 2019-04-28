<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMallsPost extends FormRequest
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

     /**场景
     * 
     * [$scene description]
     * @var [type]
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [  
            'name'=>'require|email && numeric|unique:users|checkName',     //非空 格式 唯一
            'code'=>'require|checkCode',   
            'password'=>'require|checkPwd',
            'pwd'=>'require|checkPwd1',
        ];
    }
    public function message()
    {
        return [
            'name.require'=>'账号必填',
            'name.email'=>'账号格式不正确',
            'name.tel'=>'账号格式不正确'
            'name.unique'=>'邮箱已被注册', 
            'code.require'=>'验证码必填',
            'password.require'=>'密码必填',
            'pwd.require'=>'确认密码必填',
        ];
    }

    /**验证码验证
     * [checkCode description]
     */
    protected function checkCode($value,$rule,$data=[]){
        $code = session('nameInfo.code');
        $send_time = session('nameInfo.send_time');
        if ($value!=$code) {
            return '验证码有误';
        }else if (time()-$send_time>30000) {
            return '验证码5分钟内输入有效';
        }else{
            return true;
        }
    }

    /**密码验证
     * [checkPwd description]
     */
    protected function checkPwd($value,$rule,$data=[]){
        $reg = '/^[A-Za-z0-9]{6,18}$/';
        if (!preg_match($reg,$value)) {
            return '密码必须6~18位数字或字母';
        }else{
            return true;
        }
    }

    /**确认密码验证
     * [checkPwd1 description]
     */
    protected function checkPwd1($value,$rule,$data=[]){
       if ($value!=$data['password']) {
           return '确认密码必须与密码一致';
       }else{
           return true;
       }
    }




}
