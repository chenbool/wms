<?php
namespace app\model;
use think\Model;

class OrderList extends Model
{
	protected $pk = 'id';


    public function findGood()
    {
        return $this->hasOne('\app\model\Product','id','good_id');
    }
}