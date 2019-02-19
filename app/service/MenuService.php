<?php
namespace app\service;

use app\model\Menu,
    app\model\User;
use think\Db;

class MenuService
{
    protected $menuModel;

    protected $controller;

    public function __construct()
    {
        $this->menuModel = new Menu();
    }

    /**
     * 获取目录树状结构
     */
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

    /**
     * 获取权限树状数据
     */
    public function getPermissionTree()
    {
        $menuList = Db::name('menu')->select();
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

    public function info($id)
    {
        return $this->menuModel->where('id',$id)->find();
    }

    public function save($data)
    {
        $validate = validate('MenuValidate');
        $flag = $validate->check($data);
        if(!$flag){
            return ['error'=>100,'msg'=>$validate->getError()];
        }
        if(!empty($data['id'])){
            $menu = $this->menuModel->find($data['id']);
        }else{
            $menu = new Menu();
            $menu->add_time = time();
        }
        $menu->data($data);
        if(!empty($menu->controller)){
            list($menu->controller,$menu->action) = explode('/',$menu->controller);
        }
        $flag = $menu->save();
        if($flag === false){
            return ['error'=>100,'msg'=>$menu->getError()];
        }
        return ['error'=>0,'msg'=>$menu->getError(),'data'=>$menu];
    }

    public function status($id,$status)
    {
        $flag = $this->menuModel->where('id',$id)->update(['status'=>$status]);
        if($flag){
            return ['error'=>0,'msg'=>'操作成功'];
        }else{
            return ['error'=>100,'msg'=>'操作失败：'.$this->menuModel->getError()];
        }
    }

}
