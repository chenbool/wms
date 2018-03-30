<?php
namespace app\validate;
use think\Validate;

class ShelveValidate extends Validate
{
    protected $rule = [
        'name'      =>  'require|max:25',
        'location'   =>  'require',
        'desc'      =>  'max:100'
    ];

    protected $message  =   [
        'name.require'      =>  '货架名称必填',
        'name.max'          =>  '货架名称最多不能超过25个字符',
        'location.require'  =>  '请选择库位',
        'desc.max'          =>  '备注最多不能超过100个字符'
    ];
}