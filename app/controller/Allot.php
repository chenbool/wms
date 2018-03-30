<?php
namespace app\controller;
use app\service\OrderService;

//调拨
class Allot extends Base
{
    protected $service;
    public function __construct(OrderService $service)
    {
        parent::__construct();
        $this->service = $service;
    }  

    public function index()
    {
    	$this->assign(['list'  =>  $this->service->page()]);
        return view();
    }
}
