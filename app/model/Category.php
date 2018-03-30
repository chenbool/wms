<?php
namespace app\model;
use think\Model;

class Category extends Model
{
	protected $pk = 'id';

	public function getFather(){
		return $this->hasOne('\app\model\Category','id','pid');
	}
	
}
