<?php
namespace app\model;
use think\Model;

class Location extends Model
{
	protected $pk = 'id';

    public function findStorage()
    {
        return $this->hasOne('\app\model\Storage','id','storage');
    }
}

