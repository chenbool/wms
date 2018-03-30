<?php
namespace app\model;
use think\Model;

class Order extends Model
{
	protected $pk = 'id';

	public function getList()
    {
        return $this->hasManyThrough('\app\model\Product','\app\model\OrderList','order_id','id','id');
    }

  //   public function getL(){
		// $this->alias('a')
		// 	->join('order_list b','a.id = b.order_id')
		// 	->join('product c','b.good_id = c.id')
		// 	->select();
  //   }

}

