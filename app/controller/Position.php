<?php
namespace app\controller;
use app\service\LocationService,
    app\model\Storage;

class Position extends Base
{
    protected $service;
    public function __construct(LocationService $service)
    {
        parent::__construct();
        $this->service = $service;
    }  

    public function index()
    {
        $this->assign([
            'list'  =>  $this->service->page(),
            'storage'   =>  Storage::get([ 'status' =>  0 ])
        ]);
        return view();
    }

    public function create()
    {
        $this->assign([
            'storage'  =>  Storage::get([ 'status' =>  0 ])
        ]);

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
            'storage'   =>  Storage::all()
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
