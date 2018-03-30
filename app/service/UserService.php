<?php
namespace app\service;
use think\Request,
	app\model\User,
	app\model\Role,
	app\model\Company,
	app\validate\UserValidate;

class UserService
{

    // public function page(){
    //     return User::where('status',0)->paginate(10);
    // }

    public function getVar(){
        return [
        	'company'	=>	Company::all(),
        	'role'		=>	Role::all(),
        ];
    }    

    public function page(){

    	$data 	= Request::instance()->get();
    	$where 	= [];

    	//封装where查询条件
    	(empty($data['role']) 		|| $data['role'] == '')		|| $where['role'] 		= 	$data['role'];
    	(empty($data['status']) 	|| $data['status'] == '')	|| $where['status'] 	= 	$data['status'];
    	(empty($data['company']) 	|| $data['company'] == '')	|| $where['company'] 	= 	$data['company'];
    	empty($data['truename'])	|| $where['truename']		=	[ 'like','%'.$data['truename'] ];
    	empty($data['sn'])			|| $where['sn'] 			= 	$data['sn'];

        return User::where($where)->paginate(10);     
    }

    // 保存数据
    public function save(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			if( User::get(['sn' => $param['sn'] ]) ){
				return ['error'	=>	100,'msg'	=>	'员工编号已经存在'];
				exit();	
			}

			$user 			= new User();
			$user->sn 		= $param['sn'];
			// $user->name 	= $param['name'];
			$user->role 	= $param['role'];
			$user->desc 	= $param['desc'];
			$user->status 	= $param['status'];
			$user->company 	= $param['company'];
			$user->company 	= $param['company'];
			$user->truename = $param['truename'];
			$user->username = $param['sn'];
			$user->password = md5($param['password']);
			$user->add_time = time();

			// 检测错误
			if( $user->save() ){
				return ['error'	=>	0,'msg'	=>	'保存成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'保存失败'];	
			}
			
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}

    }


    public function edit($id){
    	return User::get($id);
    }


    public function update(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			$user = User::get($param['id']);
			$user->sn 		= $param['sn'];
			$user->role 	= $param['role'];
			$user->desc 	= $param['desc'];
			$user->status 	= $param['status'];
			$user->company 	= $param['company'];
			$user->truename = $param['truename'];
			// $user->username = $param['username'];
			$user->password = md5($param['password']);

			// 检测错误
			if( $user->save() ){
				return ['error'	=>	0,'msg'	=>	'修改成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'修改失败'];	
			}
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}


    }

    public function delete($id){
    	if( User::destroy($id) ){
    		return ['error'	=>	0,'msg'	=>	'删除成功'];
    	}else{
    		return ['error'	=>	100,'msg'	=>	'删除失败'];	
    	}

		// 支持批量删除多个数据
		// User::destroy('1,2,3');
		// // 或者
		// User::destroy([1,2,3]);
    }


    // 验证器
    private function _validate($data){
		// 验证
		$validate = validate('UserValidate');
		if(!$validate->check($data)){
			return $validate->getError();
		}
    }

}
