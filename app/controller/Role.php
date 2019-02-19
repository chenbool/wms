<?php
namespace app\controller;
use app\service\RoleService;

class Role extends Base
{
    protected $service;
    public function __construct(RoleService $service)
    {
        parent::__construct();
        $this->service = $service;
    }  

    public function index()
    {
		$this->assign(['list'	=>	$this->service->page()]);
        return view();
    }
    
    public function create(){
        $this->assign([
            'menu' => json_encode(permission_jstree_data($this->service->menu())),
        ]);
        return view();
    }

    public function save()
    {
        return $this->service->save();
    }


    public function edit($id)
    {
        $info = $this->service->edit($id);
        $this->assign([
            'info'  =>  $info,
            'menu'   =>  json_encode(permission_jstree_data($this->service->menu(),explode(',', $info->ids))),
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
