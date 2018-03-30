<?php
namespace app\validate;
use think\Validate;

class UserValidate extends Validate
{
    protected $rule = [
        'truename'  =>  'require|max:25',
        // 'username'  =>  'require',
        'sn'  		=>  'require',
        'desc'      =>  'max:100',
    ];

    protected $message  =   [
        'sn.require'  		=>  '员工编号必填',
        'truename.require'  =>  '员工姓名必填',
        'truename.max'      =>  '员工姓名最多不能超过25个字符',
        // 'username.require'  =>  '登录账户必填',
        'password.require'  =>  '登录密码必填',
        'desc.max'          =>  '备注最多不能超过100个字符'
    ];
}