<?php
namespace app\model;
use think\Model;

class Shelve extends Model
{
	protected $pk = 'id';
	
    public function findLocation()
    {
        return $this->hasOne('\app\model\Location','id','location');
    }
}

