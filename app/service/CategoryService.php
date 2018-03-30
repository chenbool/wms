<?php
namespace app\service;
use think\Request,
	app\model\Category,
	app\validate\CategoryValidate;

class CategoryService
{

    public function page(){

    	$data 	= Request::instance()->get();
    	$where 	= [];

    	//封装where查询条件
    	(empty($data['status']) || $data['status'] == '')	|| $where['status'] 	= 	$data['status'];
    	empty($data['name'])	|| $where['name']		= 	['like','%'.$data['name'] ];
    	empty($data['pid'])		|| $where['pid'] 		= 	$data['pid'];
    	empty($data['sn'])		|| $where['id'] 		= 	$data['sn'];

        return Category::where($where)->paginate(10);     
    }


    public function getList(){
    	return Category::all( [ 'status' => 0 ] ); 
    }


    // 保存数据
    public function save(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			if( Category::get(['name' => $param['name'] ]) ){
				return ['error'	=>	100,'msg'	=>	'名称已经存在'];
				exit();	
			}

			$category 			= new Category();
			$category->name 	= $param['name'];
			$category->pid 		= $param['pid'];
			$category->desc 	= $param['desc'];
			$category->add_time = time();

			// 检测错误
			if( $category->save() ){
				return ['error'	=>	0,'msg'	=>	'保存成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'保存失败'];	
			}
			
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}

    }


    public function edit($id){
    	return Category::get($id);
    }


    public function update(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			$category = Category::get($param['id']);
			$category->name 	= $param['name'];
			$category->pid 		= $param['pid'];
			$category->desc 	= $param['desc'];
			$category->status 	= $param['status'];

			// 检测错误
			if( $category->save() ){
				return ['error'	=>	0,'msg'	=>	'修改成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'修改失败'];	
			}
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}


    }

    public function delete($id){
    	if( Category::destroy($id) ){
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
		$validate = validate('CategoryValidate');
		if(!$validate->check($data)){
			return $validate->getError();
		}
    }

}
