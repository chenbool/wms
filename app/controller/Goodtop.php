<?php
namespace app\controller;
use app\service\GoodtopService;

class Goodtop extends Base
{
    protected $service;
    public function __construct(GoodtopService $service)
    {
        parent::__construct();
        $this->service = $service;
    }  

    public function index()
    {
        $this->assign(['list'  =>  $this->service->page()]);
        return view();
    }
    
    public function edit($id)
    {
        $this->assign( $this->service->_init() );
        $this->assign([
            'info'  =>  $this->service->edit($id)
        ]);   
        return view();
    }

    public function update(){
        return $this->service->update();
    }

    public function delete($id){
        return $this->service->delete($id);
    }
    
}
