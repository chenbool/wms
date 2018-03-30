<?php
namespace app\validate;
use think\Validate;

class OrderValidate extends Validate
{
    protected $rule = [
        'author'      =>  'require|max:25',
        'sn'      =>  'require',
        'desc'      =>  'max:100'
    ];

    protected $message  =   [
        'author.require'    =>  '制单者必填',
        'author.max'        =>  '制单者最多不能超过25个字符',
        'sn.require'        =>  'SN必填',
        'desc.max'          =>  '备注最多不能超过100个字符'
    ];
}
