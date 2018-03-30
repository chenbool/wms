<?php
namespace app\service;
use think\Request,
	app\model\Location,
	app\validate\LocationValidate;

class LocationService
{

    public function page(){

    	$data 	= Request::instance()->get();
    	$where 	= [];

    	//封装where查询条件
    	(empty($data['status']) || $data['status'] == '')	|| $where['status'] = $data['status'];
    	empty($data['name'])	|| $where['name']		= 	['like','%'.$data['name'] ];
    	empty($data['storage'])	|| $where['storage'] 	= 	$data['storage'];
    	empty($data['sn'])		|| $where['sn'] 		= 	$data['sn'];

        return Location::where($where)->paginate(10);     
    }

    // 保存数据
    public function save(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			$location 			= new Location();
			$location->sn 		= $param['sn'];
			$location->name 	= $param['name'];
			$location->storage 	= $param['storage'];
			$location->status 	= $param['status'];
			$location->desc 	= $param['desc'];
			$location->add_time 	= time();

			// 检测错误
			if( $location->save() ){
				return ['error'	=>	0,'msg'	=>	'保存成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'保存失败'];	
			}
			
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}

    }


    public function edit($id){
    	return Location::get($id);
    }


    public function update(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			$location = Location::get($param['id']);
			// $location->sn 		= $param['sn'];
			$location->name 	= $param['name'];
			$location->storage 	= $param['storage'];
			$location->status 	= $param['status'];
			$location->desc 	= $param['desc'];

			// 检测错误
			if( $location->save() ){
				return ['error'	=>	0,'msg'	=>	'修改成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'修改失败'];	
			}
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}


    }

    public function delete($id){
    	if( Location::destroy($id) ){
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
		$validate = validate('LocationValidate');
		if(!$validate->check($data)){
			return $validate->getError();
		}
    }

}
