<?php
namespace app\validate;
use think\Validate;

class ProductupValidate extends Validate
{
    protected $rule = [
        'num'      =>  'require'
    ];

    protected $message  =   [
        'num.require'      =>  '上架数量不能为空',
    ];
}