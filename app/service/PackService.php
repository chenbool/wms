<?php
namespace app\service;
use think\Request,
	app\model\OrderGood;

class PackService
{

    public function page(){
        // pick_status
        $data   = Request::instance()->get();
        $where  = [];

        //封装where查询条件
        (empty($data['status'])         || $data['status'] == '')           || $where['pick_status'] = $data['status'];
        (empty($data['tally_status'])   || $data['tally_status'] == '')     || $where['tally_status'] = $data['tally_status'];
        empty($data['receiver_name'])   || $where['receiver_name']          =   ['like','%'.$data['receiver_name'] ];
        empty($data['sn'])              || $where['order_sn']               =   $data['sn'];

        return OrderGood::where($where)->paginate(10);     
    }
 
    public function getOne($id){
        return OrderGood::get([
        	'rec_id'	=>	$id
        ]);
    }  

    public function getSn(){
        Request::instance()->isPost() || die('request not  post!');
        $param = Request::instance()->param();  //获取参数

        return OrderGood::get([
            'order_sn'    =>  $param['sn']
        ]);
    } 

    public function prints($id){
    	
        return [
        	'info'	=>	$this->getOne($id),
        	'list'	=>	$this->getOne($id)
        ];
    }  


    public function packAdd($id){
        $info = OrderGood::get(['rec_id'    =>  $id]);
        $info->pick_status = !$info->pick_status;
        $info->save();
        return [
            'error' => 0,
            'msg'   =>  '操作成功'
        ];
    }

    public function arrangeAdd($id,$status){
        $info = OrderGood::get(['rec_id'    =>  $id]);
        $info->tally_status = $status;

        $res = $info->save();
        // dump($res);
        // die;
        return [
            'error' => 0,
            'msg'   =>  '操作成功'
        ];
    }


}
