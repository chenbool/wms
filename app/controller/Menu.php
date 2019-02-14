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
        $pid = $this->request->param('pid',0);
        $list = $this->service->dataList();
        $menuPath = $this->service->getPath($pid);
        $this->assign([
            'list' => $list,
            'menuPath' => $menuPath,
            'pid'=>$pid
        ]);
        return $this->fetch();
    }

}