<?php
namespace app\controller;
use app\service\UserService;

class User extends Base
{
    protected $service;
    public function __construct(UserService $service)
    {
        parent::__construct();
        $this->service = $service;
    }  

    public function index()
    {
        $this->assign($this->service->getVar());
		$this->assign(['list'	=>	$this->service->page()]);
        return view();
    }

    public function create()
    {
        $this->assign($this->service->getVar());
        return view();
    }


    public function save()
    {
        return $this->service->save();
    }

    public function edit($id)
    {
        $this->assign($this->service->getVar());
        $this->assign(['info' => $this->service->edit($id)]);   
        return view();
    }

    public function update(){
        return $this->service->update();
    }

    public function delete($id){
        return $this->service->delete($id);
    }

}
