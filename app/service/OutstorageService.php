<?php
namespace app\service;
use think\Request,
	app\model\Order,
	app\model\Product,
	app\model\OrderList,
	app\validate\OrderValidate;

class OutstorageService
{

    public function page(){

    	$data 	= Request::instance()->get();
    	$where 	= [];
    	
    	//封装where查询条件
    	empty($data['type']) 	|| $where['type'] 	= 	$data['type'];
    	empty($data['author'])	|| $where['author']		= 	['like','%'.$data['author'] ];
    	empty($data['sn'])		|| $where['sn'] 		= 	$data['sn'];

    	$where['state'] 		= 	2;

        return Order::where($where)->paginate(10);     
    }

    // 保存数据
    public function save(){
    	Request::instance()->isPost() || die('request not  post!');
    	
		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证


		if( is_null( $error ) ){

			$order 				= new Order();
			$order->sn 			= $param['sn'];
			$order->type 		= $param['type'];
			$order->desc 		= $param['desc'];
			$order->author 		= $param['author'];
			$order->supplier 	= $param['supplier'];
			$order->car_no 		= $param['car_no'];
			$order->ban_no 		= $param['ban_no'];
			$order->detailed_no = $param['detailed_no'];
			$order->state 		= 2;
			$order->add_time	= time();

			// 检测错误
			if( $order->save() ){
				$id = $order->id;
				//插入并更新
				$this->addList($param,$id);
				return ['error'	=>	0,'msg'	=>	'保存成功'];
			}else{
				return ['error'	=>	100,'msg'	=>	'保存失败'];	
			}
			
		}else{
			return ['error'	=>	100,'msg'	=>	$error];
		}

    }

    //插入列表
    public function addList($data,$order_id){

    	foreach ($data['product'] as $k=>$v) {

    		//id更新产品数量
			$product = Product::get($v);
			$product->num -=  $data['num'][$k];
			$product->save();


			//添加到订单列表
			OrderList::create([
				'good_id'	=>	$v,
				'order_id'	=>	$order_id,
				'num'		=>	$data['num'][$k]
			]);
    	}

    }


    public function getAllList($id){
    	return OrderList::All([
    		'order_id'	=> $id
    	]);
    }

    public function edit($id){
    	return Order::get($id);
    }


  //   public function update(){
  //   	Request::instance()->isPost() || die('request not  post!');
    	
		// $param = Request::instance()->param();	//获取参数
		// $error = $this->_validate($param); 		// 是否通过验证

		// if( is_null( $error ) ){

		// 	$order = Order::get($param['id']);
		// 	$order->sn 			= $param['sn'];
		// 	$order->res 		= $param['res'];
		// 	$order->type 		= $param['type'];
		// 	$order->desc 		= $param['desc'];
		// 	$order->author 		= $param['author'];
		// 	$order->supplier 	= $param['supplier'];
		// 	$order->state 		= 1;

		// 	// 检测错误
		// 	if( $order->save() ){
		// 		return ['error'	=>	0,'msg'	=>	'修改成功'];
		// 	}else{
		// 		return ['error'	=>	100,'msg'	=>	'修改失败'];	
		// 	}
		// }else{
		// 	return ['error'	=>	100,'msg'	=>	$error];
		// }


  //   }

    public function delete($id){
    	if( Order::destroy($id) ){
    		return ['error'	=>	0,'msg'	=>	'删除成功'];
    	}else{
    		return ['error'	=>	100,'msg'	=>	'删除失败'];	
    	}
    }


    // 验证器
    private function _validate($data){
		// 验证
		$validate = validate('OrderValidate');
		if(!$validate->check($data)){
			return $validate->getError();
		}
    }




}
