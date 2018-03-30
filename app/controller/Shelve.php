<?php
namespace app\controller;
use app\service\ShelveService,
    app\model\Location;

class Shelve extends Base
{
    protected $service;
    public function __construct(ShelveService $service)
    {
        parent::__construct();
        $this->service = $service;
    }  

    public function index()
    {
        $this->assign([
            'list'  =>  $this->service->page(),
            'location'   =>  Location::all()
        ]);
        return view();
    }

    public function create()
    {
        $this->assign([
            'location'  =>  Location::all()
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
            'location'   =>  Location::all()
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
