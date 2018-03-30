<?php
namespace app\model;
use think\Model;

class User extends Model
{
	protected $pk = 'id';
	// protected $table = 'think_user';

    public function findRole()
    {
        return $this->hasOne('\app\model\Role','id','role');
    }

    public function findCompany()
    {
        return $this->hasOne('\app\model\Company','id','company');
    }

}

