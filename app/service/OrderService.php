<?php
namespace app\service;
use think\Request,
	app\model\Unit,
	app\model\OrderInfo,
	app\validate\UnitValidate;

class OrderService
{

    public function page(){

    	$data 	= Request::instance()->get();
    	$where 	= [];

    	//封装where查询条件
    	(empty($data['status']) 	|| $data['status'] == '')	|| $where['status'] 	= 	$data['status'];
    	empty($data['product_no'])	|| $where['product_no']		= 	['like','%'.$data['product_no'] ];
    	empty($data['sn'])			|| $where['order_sn'] 		= 	$data['sn'];

        return OrderInfo::where($where)->paginate(10);     
    }

    public function getNew(){
        return OrderInfo::order('order_id desc')->paginate(10);     
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

    //文件上传
    public function upload($file){
    	Request::instance()->isPost() || die('request not  post!');    

	    // 移动到框架应用根目录/public/uploads/ 目录下
	    if($file){
	        // $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
	        // 移动到框架应用根目录/public/uploads/ 目录下
    		$info = $file->validate(['ext'=>'xls,xlsx'])->move(ROOT_PATH . 'public' . DS . 'uploads');
	        if($info){
	            // 成功上传后 获取上传信息
	            // 输出文件后缀 xls
	            // echo $info->getExtension();

	            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
	            // echo $info->getSaveName();
	            
	            $excel = new ExcelService();
		        $excel->read(ROOT_PATH.'public'.DS.'uploads/'.$info->getSaveName() ) ;
		       	return true;

	            // 输出 42a79759f284b767dfcb2a0197904287.jpg
	            // echo $info->getFilename(); 
	        }else{
	            // 上传失败获取错误信息
	            echo $file->getError();
	        }
	    }

    }

 //    public function uploads($file){    
 //        $excel = new ExcelService();
 //        $excel->read() ;
 //        return true;
	// }	       	

}
