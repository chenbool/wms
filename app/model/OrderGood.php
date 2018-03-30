<?php
namespace app\model;
use think\Model;

class OrderGood extends Model
{
	protected $pk = 'rec_id';

	public function getList()
    {
        // return $this->hasMany('\app\model\OrderList','rec_id','order_id');
        return $this->hasMany('\app\model\OrderList','order_id','rec_id');
    }

}