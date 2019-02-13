<?php
namespace app\service;

use app\model\Menu,
    app\model\User;
use think\Db;

class MenuService
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new Menu();
    }

    public function getFather()
    {
        return $this->menuModel->where([
            'status' => 0,
            'level' => 0
        ])->select();
    }

    public function getChild()
    {
        return $this->menuModel->where([
            'status' => 0,
            'level' => ['>', 0]
        ])->select();
    }

    public function getMenu($ids)
    {

        return [
            'father' => $this->menuModel->where([
                'status' => 0,
                'level' => 0,
                'id' => ['in', "$ids"]
            ])->select(),
            'child' => $this->menuModel->where([
                'status' => 0,
                'level' => ['>', 0],
                'id' => ['in', "$ids"]
            ])->select()
        ];
    }

    public function getMenuAll()
    {
        return [
            'father' => $this->menuModel->where([
                'status' => 0,
                'level' => 0
            ])->select(),
            'child' => $this->menuModel->where([
                'status' => 0,
                'level' => ['>', 0]
            ])->select()
        ];
    }

    public function getMenuTree($ids = null)
    {
        if (empty($ids)) {
            $menuList = Db::name('menu')->where([
                'status' => 0,
            ])->select();
        } else {
            $menuList = Db::name('menu')->where([
                'status' => 0, 'id' => ['in', "$ids"]
            ])->select();
        }

        if(empty($menuList)) return [];
        return $this->menuTree($menuList);

    }

    public function menuTree(array $menuList,$pid = 0,$child = 'child')
    {
        $result = [];
        foreach($menuList as $key => $val){
            if($val['pid'] == $pid){
                $result[] = $val;
                unset($menuList[$key]);
            }
           
        }

        foreach($result as $key => $val){
            $result[$key][$child] = $this->menuTree($menuList,$val['id']);
        }
        return $result;
    }

    public function getMenuShow($obj)
    {
        //是否是超级管理员
        if ($obj->id == '1') {
            $_menuList = $this->getMenuTree();
        } else {
            $_menuList = $this->getMenuTree($obj->findRole->ids);
        }

        return [
            'my_info' => $obj,
            '_menuList' => $_menuList
        ];
    }

    public function is_auth()
    {

    }


}
