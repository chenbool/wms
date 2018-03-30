<?php
namespace app\service;
use think\Request,
	app\model\Unit,
	app\validate\UnitValidate;

class UnitService
{

    public function page(){

    	$data 	= Request::instance()->get();
    	$where 	= [];

    	//封装where查询条件
    	(empty($data['status']) || $data['status'] == '')	|| $where['status'] 	= 	$data['status'];
    	empty($data['name'])	|| $where['name']		= 	['like','%'.$data['name'] ];
    	empty($data['sn'])		|| $where['id'] 		= 	$data['sn'];

        return Unit::where($where)->paginate(10);     
    }

    // 保存数据
    public function save(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			if( Unit::get(['name' => $param['name'] ]) ){
				return ['error'	=>	100,'msg'	=>	'名称已经存在'];
				exit();	
			}

			$unit 			= new Unit();
			$unit->name 	= $param['name'];
			$unit->desc 	= $param['desc'];
			$unit->status 	= $param['status'];
			$unit->add_time = time();

			// 检测错误
			if( $unit->save() ){
				return ['error'	=>	0,'msg'	=>	'保存成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'保存失败'];	
			}
			
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}

    }


    public function edit($id){
    	return Unit::get($id);
    }


    public function update(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			$unit = Unit::get($param['id']);
			$unit->name 		= $param['name'];
			$unit->desc 		= $param['desc'];
			$unit->status 	= $param['status'];

			// 检测错误
			if( $unit->save() ){
				return ['error'	=>	0,'msg'	=>	'修改成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'修改失败'];	
			}
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}


    }

    public function delete($id){
    	if( Unit::destroy($id) ){
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
		$validate = validate('UnitValidate');
		if(!$validate->check($data)){
			return $validate->getError();
		}
    }

}
