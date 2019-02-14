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


    public function getMenuTree($ids = null)
    {
        $menuList = session('user_menu'); //先从session里获取用户菜单
        if (empty($ids) && empty($menuList)) {
            $where = ['status' => 0,];
        } elseif(empty($menuList)) {
            $where = ['status' => 0, 'id' => ['in', "$ids"]];
        }
        if(empty($menuList)){
            $menuList = Db::name('menu')->where($where)->select();
            session('user_menu',$menuList);
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
        $super_admin = config('super_admin');
        if (isset($super_admin) && in_array($obj->id,$super_admin)) {
            $_menuList = $this->getMenuTree();
        } else {
            $_menuList = $this->getMenuTree($obj->findRole->ids);
        }

        return $_menuList;
    }

    public function checkPermission($ids,$controller,$action)
    {
        if(empty($ids)){
            return false;
        }
        $permission = session('role_permission');
        if(!$permission){
            $permission = [];
            $temp = $this->menuModel->where('id','in',$ids)->select();
            $temp = collection($temp)->toArray();
            foreach($temp as $val){
                if(!empty($val['controller'])){
                    $permission[$val['controller']."/".$val['action']] = 1;
                }
            }
            session('role_permission',$permission);
        }
        return isset($permission[$controller.'/'.$action]);
    }

    public function dataList()
    {
        $data = request()->param();

        $where = [];
        if(empty($data['pid'])){
            $where['pid'] = 0;
        }else{
            $where['pid'] = $data['pid'];
        }
    
        return $this->menuModel->where($where)->select();
    }

    public function getPath($pid)
    {
        $path = [];
        if(empty($pid)){
            return $path;
        }
        $row = $this->menuModel->cache()->column('id,name,pid,controller,action');
        for(;;$pid!=0){
            if(empty($row[$pid])){
                break;
            }
            array_unshift($path,$row[$pid]);
            $pid = $row[$pid]['pid'];
        }
        return $path;
        
    }


}
