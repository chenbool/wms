<?php
namespace app\validate;
use think\Validate;

class RoleValidate extends Validate
{
    protected $rule = [
        'name'      =>  'require|max:25',
        'ids'      =>  'require',
        'desc'      =>  'max:100'
    ];

    protected $message  =   [
        'name.require'      =>  '名称必填',
        'ids.require'       =>  '至少选择一个',
        'name.max'          =>  '名称最多不能超过25个字符', 
        'desc.max'          =>  '备注最多不能超过100个字符'
    ];
}
