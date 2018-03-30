<?php
namespace app\service;
use think\Request,
	app\model\Company,
	app\model\Menu,
	app\validate\CompanyValidate;

class CompanyService
{

    public function page(){
    	$data 	= Request::instance()->get();
    	$where 	= [];

    	//封装where查询条件
    	(empty($data['status']) || $data['status'] == '')	|| $where['status'] = $data['status'];
    	empty($data['name'])	|| $where['name']			= 	['like','%'.$data['name'] ];
    	empty($data['email'])	|| $where['email'] 			= 	$data['email'];
    	empty($data['tel'])		|| $where['tel'] 			= 	$data['tel'];
    	empty($data['sn'])		|| $where['id'] 			= 	$data['sn'];

        return Company::where($where)->paginate(10);     
        // return Company::where('status',0)->paginate(10);
    }
  

    // 保存数据
    public function save(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			if( Company::get(['name' => $param['name'] ]) ){
				return ['error'	=>	100,'msg'	=>	'名称已经存在']; exit();	
			}

			$company 			= new Company();
			$company->name 		= $param['name'];
			$company->tel 		= $param['tel'];
			$company->email 	= $param['email'];
			$company->address 	= $param['address'];
			$company->desc 		= $param['desc'];
			$company->add_time 	= time();

			// 检测错误
			if( $company->save() ){
				return ['error'	=>	0,'msg'	=>	'保存成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'保存失败'];	
			}
			
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}
    }

    public function update(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			$company = Company::get($param['id']);
			$company->name 		= $param['name'];
			$company->tel 		= $param['tel'];
			$company->email 	= $param['email'];
			$company->address 	= $param['address'];
			$company->desc 		= $param['desc'];

			// 检测错误
			if( $company->save() ){
				return ['error'	=>	0,'msg'	=>	'修改成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'修改失败'];	
			}

		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}


    }

    // 验证器
    private function _validate($data){
		// 验证
		$validate = validate('CompanyValidate');
		if(!$validate->check($data)){
			return $validate->getError();
		}
    }

    public function edit($id){
    	return Company::get($id);
    }


    public function delete($id){
    	if( Company::destroy($id) ){
    		return ['error'	=>	0,'msg'	=>	'删除成功'];
    	}else{
    		return ['error'	=>	100,'msg'	=>	'删除失败'];	
    	}

		// 支持批量删除多个数据
		// User::destroy('1,2,3');
		// // 或者
		// User::destroy([1,2,3]);
    }

}
