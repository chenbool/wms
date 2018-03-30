<?php
namespace app\service;
use think\Request,
	app\model\Shelve,
	app\validate\ShelveValidate;

class ShelveService
{

    public function page(){

    	$data 	= Request::instance()->get();
    	$where 	= [];

    	//封装where查询条件
    	(empty($data['status']) 	|| $data['status'] == '')	|| $where['status'] = $data['status'];
    	empty($data['name'])		|| $where['name']			= 	['like','%'.$data['name'] ];
    	empty($data['location'])	|| $where['location'] 		= 	$data['location'];
    	empty($data['sn'])			|| $where['sn'] 			= 	$data['sn'];

        return Shelve::where($where)->paginate(10);     
    }

    // 保存数据
    public function save(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			$shelve 			= new Shelve();
			$shelve->sn 		= $param['sn'];
			$shelve->name 		= $param['name'];
			$shelve->location 	= $param['location'];
			$shelve->list 		= $param['list'];
			$shelve->status 	= $param['status'];
			$shelve->desc 		= $param['desc'];
			$shelve->add_time 	= time();

			// 检测错误
			if( $shelve->save() ){
				return ['error'	=>	0,'msg'	=>	'保存成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'保存失败'];	
			}
			
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}

    }


    public function edit($id){
    	return Shelve::get($id);
    }


    public function update(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			$shelve = Shelve::get($param['id']);
			// $shelve->sn 		= $param['sn'];
			$shelve->name 		= $param['name'];
			$shelve->list 		= $param['list'];
			$shelve->location 	= $param['location'];
			$shelve->status 	= $param['status'];
			$shelve->desc 		= $param['desc'];

			// 检测错误
			if( $shelve->save() ){
				return ['error'	=>	0,'msg'	=>	'修改成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'修改失败'];	
			}
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}


    }

    public function delete($id){
    	if( Shelve::destroy($id) ){
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
		$validate = validate('ShelveValidate');
		if(!$validate->check($data)){
			return $validate->getError();
		}
    }

}
