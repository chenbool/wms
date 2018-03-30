<?php
namespace app\controller;
use app\service\CategoryService;

class Category extends Base
{
    protected $service;
    public function __construct(CategoryService $service)
    {
        parent::__construct();
        $this->service = $service;
    }  

    public function index()
    {
        $this->assign([
            'list'      =>  $this->service->page(),
            'category'  =>  $this->service->getList()
        ]);
        return view();
    }

    public function create()
    {
        // dump(  $this->service->getList() );
        // die;
        $this->assign(['category'  =>  $this->service->getList()]);
        return view();
    }


    public function save()
    {
        return $this->service->save();
    }

    public function edit($id)
    {
        $this->assign([
            'info'      =>  $this->service->edit($id),
            'category'  =>  $this->service->getList()
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
