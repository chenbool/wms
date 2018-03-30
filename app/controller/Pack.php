<?php
namespace app\controller;
use app\service\PackService;

//打包
class Pack extends Base
{
    protected $service;
    public function __construct(PackService $service)
    {
        parent::__construct();
        $this->service = $service;
    }  

    public function index()
    {
    	$this->assign(['list'  =>  $this->service->page()]);
        return view();
    }

    public function prints($id)
    {
        $this->assign(
            $this->service->prints($id)
        );
        return view();
    }

    public function send()
    {
        return view();
    }

    public function getSn()
    {
        $info = $this->service->getSn();

        $tempGood = [];
        $total = 0;
        foreach ($info->getList as $k =>$vo) {
            $tempGood[$k]['name']     =   $vo->findGood->name;
            $tempGood[$k]['sn']       =   $vo->findGood->sn;
            $tempGood[$k]['price']    =   $vo->findGood->price;
            $tempGood[$k]['num']      =   $vo->num;
            $tempGood[$k]['unit']     =   $vo->findGood->unit;
            $tempGood[$k]['count']    =   $vo->num*$vo->findGood->price;
            $total                    += $tempGood[$k]['count'];
        }

        return [
            'sn'    =>  $info->order_sn,
            'receiver_name' =>  $info->receiver_name,
            'receiver_phone' =>  $info->receiver_phone,
            'delivery'  =>  $info->delivery,
            'list'      =>  json_encode($tempGood),
            'total'     =>  $total
        ];
    }


    public function pack()
    {
        $this->assign(['list'  =>  $this->service->page()]);
        return view();
    }

    public function packAdd($id)
    {
        return $this->service->packAdd($id);
        // dump($id);
    }

    public function arrange()
    {
        $this->assign(['list'  =>  $this->service->page()]);
        return view();
    }

    public function arrangeAdd($id,$status)
    {
        return $this->service->arrangeAdd($id,$status);
    }


}
