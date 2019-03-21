<?php
namespace app\model;
use think\Model;

class Menu extends Model
{
	protected $pk = 'id';


	public function getStatusTextAttr($value,$data)
    {
        $status = [-1=>'删除',0=>'显示',1=>'禁用',2=>'不显示'];
        return $status[$data['status']];
    }
}

