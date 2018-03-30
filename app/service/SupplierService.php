<?php
namespace app\service;
use think\Request,
	app\model\Supplier,
	app\validate\SupplierValidate;

class SupplierService
{

    public function page(){
    	$data 	= Request::instance()->get();
    	$where 	= [];

    	//封装where查询条件
    	(empty($data['status']) || $data['status'] == '')	|| $where['status'] = $data['status'];
    	empty($data['contact'])	|| $where['contact']		=	['like','%'.$data['contact'] ];
    	empty($data['name'])	|| $where['name']			= 	['like','%'.$data['name'] ];
    	empty($data['phone'])	|| $where['phone'] 			= 	$data['phone'];
    	empty($data['eamil'])	|| $where['eamil'] 			= 	$data['eamil'];
    	empty($data['sn'])		|| $where['sn'] 			= 	$data['sn'];

        return Supplier::where($where)->paginate(10);     
    }

    // 保存数据
    public function save(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			if( Supplier::get(['name' => $param['name'] ]) ){
				return ['error'	=>	100,'msg'	=>	'名称已经存在']; exit();	
			}

			$supplier 			= new Supplier();
			$supplier->sn 		= $param['sn'];
			$supplier->name 	= $param['name'];
			$supplier->contact 	= $param['contact'];
			$supplier->phone 	= $param['phone'];
			$supplier->email 	= $param['email'];
			$supplier->fax 		= $param['fax'];
			$supplier->desc 	= $param['desc'];
			$supplier->address 	= $param['address'];
			$supplier->add_time = time();

			// 检测错误
			if( $supplier->save() ){
				return ['error'	=>	0,'msg'	=>	'保存成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'保存失败'];	
			}
			
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}
    }


    public function edit($id){
    	return Supplier::get($id);
    }


    public function update(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			$supplier = Supplier::get($param['id']);
			$supplier->name 	= $param['name'];
			$supplier->contact 	= $param['contact'];
			$supplier->phone 	= $param['phone'];
			$supplier->email 	= $param['email'];
			$supplier->fax 		= $param['fax'];
			$supplier->desc 	= $param['desc'];
			$supplier->address 	= $param['address'];

			// 检测错误
			if( $supplier->save() ){
				return ['error'	=>	0,'msg'	=>	'修改成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'修改失败'];	
			}
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}


    }

    public function delete($id){
    	if( Supplier::destroy($id) ){
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
		$validate = validate('SupplierValidate');
		if(!$validate->check($data)){
			return $validate->getError();
		}
    }

}
