<?php
namespace app\service;
use think\Request,
	app\model\Unit,
	app\model\Product,
	app\model\Productup,
	app\model\Storage,
	app\model\Category,
	app\model\Customer,
	app\model\Supplier,
	app\model\Location,
	app\model\Shelve,
	app\validate\ProductupValidate;

class GoodtopService
{


    public function page(){
    	$data 	= Request::instance()->get();
    	$where 	= [];

    	//封装where查询条件
    	(empty($data['status']) || $data['status'] == '')	|| $where['status'] = $data['status'];
    	empty($data['name'])	|| $where['name']			= 	['like','%'.$data['name'] ];
    	empty($data['sn'])		|| $where['sn'] 			= 	$data['sn'];

    	// $where['num'] = ['>',0]; 
        return Product::where($where)->paginate(10);     
    }


    public function _init(){

    	return [
    		'unit'		=>	Unit::all(     [ 'status' => 0 ] ),
    		'category'	=>	Category::all( [ 'status' => 0 ] ),
    		'customer'	=>	Customer::all( [ 'status' => 0 ] ),
    		'supplier'	=>	Supplier::all( [ 'status' => 0 ] ),
    		'storage'	=>	Storage::all(  [ 'status' => 0 ] ),
    		'location'	=>	Location::all( [ 'status' => 0 ] ),
    		'shelve'	=>	Shelve::all( [ 'status' => 0 ] ),
    	];
    }

    public function edit($id){
    	return Product::get($id);
    }

    public function update(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			$product = Product::get($param['id']);
			if( $param['num'] > $product->num ){
				return ['error'	=>	100,'msg'	=>	'超过最大数量'];
				die;
			}
			
			$product->num -= $param['num'];
			$product->save();

			$productup = Productup::get($param['id']);
			$productup->num 		+= $param['num'];
			$productup->storage 	= $product->storage;
			$productup->location 	= $product->location;
			$productup->shelve 		= $param['shelve'];
			$productup->shelve_list = $param['shelve_list'];
			// dump( $product->num );
			// dump( $param['num'] );
			// die;

			// 检测错误
			if( $productup->save() ){
				return ['error'	=>	0,'msg'	=>	'修改成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'修改失败'];	
			}
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}


    }

    public function delete($id){
    	if( Product::destroy($id) ){
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
		$validate = validate('ProductupValidate');
		if(!$validate->check($data)){
			return $validate->getError();
		}
    }


}
