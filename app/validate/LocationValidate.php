<?php
namespace app\validate;
use think\Validate;

class LocationValidate extends Validate
{
    protected $rule = [
        'name'      =>  'require|max:25',
        'storage'   =>  'require',
        'desc'      =>  'max:100'
    ];

    protected $message  =   [
        'name.require'      =>  '库位名称必填',
        'name.max'          =>  '库位名称最多不能超过25个字符',
        'storage.require'   =>  '请选择仓库',
        'desc.max'          =>  '备注最多不能超过100个字符'
    ];
}