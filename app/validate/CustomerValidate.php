<?php
namespace app\validate;
use think\Validate;

class CustomerValidate extends Validate
{
    protected $rule = [
        'name'      =>  'require|max:100',
        'contact'   =>  'require',
        'phone'     =>  'require|number',
        'email'     =>  'require|email',
        'desc'      =>  'max:100'
    ];

    protected $message  =   [
        'name.require'      =>  '名称必填',
        'name.max'          =>  '名称最多不能超过50个字符',
        'contact.require'   =>  '联系人必填',
        'phone.require'     =>  '手机号必填',
        'phone.number'      =>  '手机号格式错误',
        'email.require'     =>  '邮箱必填',    
        'email.email'       =>  '邮箱格式错误',    
        'desc.max'          =>  '备注最多不能超过100个字符'
    ];
}
