<?php
namespace app\model;
use think\Model;

class Product extends Model
{
	protected $pk = 'id';

    public function findGoodup()
    {
        // return $this->hasOne('\app\model\Productup','id','gid');
        return $this->belongsTo('\app\model\Productup','id','gid');
    }

}

