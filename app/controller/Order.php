<?php
namespace app\controller;
use app\service\OrderService;

class Order extends Base
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


    public function import()
    {
        $this->assign(['list'  =>  $this->service->getNew() ]);
        return view();
    }

    public function create()
    {
        return view();
    }


    public function save()
    {
        return $this->service->save();
    }

    public function edit($id)
    {
        $this->assign(['info'  =>  $this->service->edit($id)]);   
        return view();
    }

    public function update(){
        return $this->service->update();
    }

    public function upload()
    {
        if( $this->service->upload( request()->file('excel') ) ){
            $this->success('导入成功', 'Order/import');
        }else{
            $this->error('导入失败');
        }
    }

    //下载
    public function down()
    {
        $filename = ROOT_PATH .'/public/static/demo.xls';
        header("content-disposition:attachment;filename=".basename($filename));
        header("content-length:24");
        return readfile($filename);
    }

    // public function delete($id){
    //     return $this->service->delete($id);
    // }

    public function pack()
    {
        $this->assign(['list'  =>  $this->service->page()]);
        return view();
    }

    public function arrange()
    {
        $this->assign(['list'  =>  $this->service->page()]);
        return view();
    }

}
