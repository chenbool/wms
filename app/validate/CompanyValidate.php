<?php
namespace app\validate;
use think\Validate;

class CompanyValidate extends Validate
{
    protected $rule = [
        'name'      =>  'require|max:25',
        'tel'      	=>  'require',
        'email'     =>  'require|email',
        'desc'      =>  'max:100'
    ];

    protected $message  =   [
        'name.require'    =>  '名称必填',
        'name.max'        =>  '名称最多不能超过25个字符',
        'tel.require'     =>  '电话必填',
        'email.require'   =>  '邮箱必填',
        'email.email'     =>  '邮箱格式不对',
        'desc.max'        =>  '备注最多不能超过100个字符'
    ];
}
