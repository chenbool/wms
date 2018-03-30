<?php
namespace app\service;
use think\Request,
	app\model\Customer,
	app\validate\CustomerValidate;

class CustomerService
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

        return Customer::where($where)->paginate(10);     
    }

    // 保存数据
    public function save(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			if( Customer::get(['name' => $param['name'] ]) ){
				return ['error'	=>	100,'msg'	=>	'名称已经存在']; exit();	
			}

			$customer 			= new Customer();
			$customer->sn 		= $param['sn'];
			$customer->name 	= $param['name'];
			$customer->contact 	= $param['contact'];
			$customer->phone 	= $param['phone'];
			$customer->email 	= $param['email'];
			$customer->fax 		= $param['fax'];
			$customer->desc 	= $param['desc'];
			$customer->address 	= $param['address'];
			$customer->add_time = time();

			// 检测错误
			if( $customer->save() ){
				return ['error'	=>	0,'msg'	=>	'保存成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'保存失败'];	
			}
			
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}
    }


    public function edit($id){
    	return Customer::get($id);
    }


    public function update(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			$customer = Customer::get($param['id']);
			$customer->name 	= $param['name'];
			$customer->contact 	= $param['contact'];
			$customer->phone 	= $param['phone'];
			$customer->email 	= $param['email'];
			$customer->fax 		= $param['fax'];
			$customer->desc 	= $param['desc'];
			$customer->address 	= $param['address'];

			// 检测错误
			if( $customer->save() ){
				return ['error'	=>	0,'msg'	=>	'修改成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'修改失败'];	
			}
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}


    }

    public function delete($id){
    	if( Customer::destroy($id) ){
    		return ['error'	=>	0,'msg'	=>	'删除成功'];
    	}else{
    		return ['error'	=>	100,'msg'	=>	'删除失败'];	
    	}
    }


    // 验证器
    private function _validate($data){
		// 验证
		$validate = validate('CustomerValidate');
		if(!$validate->check($data)){
			return $validate->getError();
		}
    }

}
