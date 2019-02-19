<?php

namespace app\controller;

use think\Request;
use app\service\MenuService;

class Menu extends Base
{
    protected $service;

    
    public function __construct(MenuService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function index()
    {
        $pid = $this->request->param('pid', 0);
        $list = $this->service->dataList();
        $menuPath = $this->service->getPath($pid);
        $this->assign([
            'list' => $list,
            'menuPath' => $menuPath,
            'pid' => $pid
        ]);
        return $this->fetch();
    }

    public function info($pid = 0, $id = 0)
    {
    
      
        if($this->request->isPost()){
            return $this->service->save($this->request->post());
        }

        $this->assign('iconList',config('icon'));
        $pMenu = $this->service->info($pid);
        if(empty($pMenu)){
            $pMenu = [
                'pid' => 0,
                'level' => -1,
                'name' => '根节点'
            ];
        }
        $this->assign('pid',$pid);
        $this->assign('level',$pMenu['level']+1);
        $this->assign('pMenu',$pMenu);
        if(!empty($id)){
            $info = $this->service->info($id);
            $this->assign('info',$info);
        }
        return $this->fetch();
    }

    public function status($id,$status)
    {
    
        $info = $this->service->status($id,$status);
        if($info['error'] == 0){
            $this->success($info['msg']);
        }else{
            $this->error($info['msg']);
        }
    }

}