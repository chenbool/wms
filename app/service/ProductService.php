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
	app\validate\ProductValidate;

class ProductService{

    public function page(){
    	$data 	= Request::instance()->get();
    	$where 	= [];

    	//封装where查询条件
    	(empty($data['status']) || $data['status'] == '')	|| $where['status'] = $data['status'];
    	empty($data['name'])	|| $where['name']			= 	['like','%'.$data['name'] ];
    	empty($data['sn'])		|| $where['sn'] 			= 	$data['sn'];

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
    	];
    }


    // 保存数据
    public function save(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if( is_null( $error ) ){

			if( Product::get(['name' => $param['name'] ]) ){
				return ['error'	=>	100,'msg'	=>	'名称已经存在'];
				exit();	
			}

			$product 			= new Product();
			$product->sn 		= $param['sn'];
			$product->nbsn 		= $param['nbsn'];
			$product->cjsn 		= $param['cjsn'];
			$product->name 		= $param['name'];
			$product->category 	= $param['category'];
			$product->storage 	= $param['storage'];
			$product->location 	= $param['location'];
			$product->unit 		= $param['unit'];
			$product->supplier 	= $param['supplier'];
			$product->customer 	= $param['customer'];
			$product->spec 		= $param['spec'];
			$product->price 	= $param['price'];
			$product->desc 		= $param['desc'];
			// $product->status 	= $param['status'];
			$product->add_time 	= time();

			// 检测错误
			if( $gid = $product->save() ){

				$productup 				= new Productup();
				$productup->gid 		= $product->id;
				$productup->storage 	= $param['storage'];
				$productup->location 	= $param['location'];
				$productup->desc 		= $param['desc'];
				$productup->add_time 	= time();
				$productup->save();

				return ['error'	=>	0,'msg'	=>	'保存成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'保存失败'];	
			}
			
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}

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
			$product->sn 		= $param['sn'];
			$product->nbsn 		= $param['nbsn'];
			$product->cjsn 		= $param['cjsn'];
			$product->name 		= $param['name'];
			$product->category 	= $param['category'];
			$product->storage 	= $param['storage'];
			$product->location 	= $param['location'];
			$product->unit 		= $param['unit'];
			$product->supplier 	= $param['supplier'];
			$product->customer 	= $param['customer'];
			$product->spec 		= $param['spec'];
			$product->price 	= $param['price'];
			$product->desc 		= $param['desc'];
			$product->status 	= $param['status'];

			// 检测错误
			if( $product->save() ){
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
    		Productup::destroy([
    			'gid' => $id
    		]);
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
		$validate = validate('ProductValidate');
		if(!$validate->check($data)){
			return $validate->getError();
		}
    }

}
