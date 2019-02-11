<?php
namespace app\controller;
use app\service\ProductService;

class Product extends Base
{
    protected $service;
    public function __construct(ProductService $service)
    {
        parent::__construct();
        $this->service = $service;
    }  

    public function index()
    {
        $this->assign(['list'  =>  $this->service->page()]);
        return view();
    }

    public function lists()
    {
        $this->index();
        return view();
    }


    public function create()
    {
        $this->assign( $this->service->_init() );
        return view();
    }


    public function save()
    {
        return $this->service->save();
    }

    public function edit($id)
    {
        $this->assign( $this->service->_init() );
        $this->assign(['info'  =>  $this->service->edit($id)]);   
        return view();
    }

    public function update(){
        return $this->service->update();
    }

    public function delete($id){
        return $this->service->delete($id);
    }
    
}
