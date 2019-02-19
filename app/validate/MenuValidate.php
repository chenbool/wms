<?php

namespace app\validate;

use think\Validate;


class MenuValidate extends Validate
{
    protected $rule = [
        'name'      =>  'require|max:25',
        'pid'   =>  'require|number',
        'level' => 'require|number',
        'controller' => 'checkController',
        'status' => 'require|number'
    ];

    protected $message  =   [
        'name.require'      =>  '名称必填',
        'pid.require'          =>  '父ID必填',
        'level.require'   =>  '级别必填',
        'status.require'          =>  '状态必填'
    ];

    public function checkController($val)
    {
        if(count(explode('/',$val)) >= 2){
            return true;
        }
        return '控制器填写错误';
    }
}