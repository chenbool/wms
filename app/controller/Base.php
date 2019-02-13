<?php
namespace app\controller;
use think\Controller,
	think\Session,
	app\model\User,
    app\service\MenuService;
use think\exception\HttpResponseException;

class Base extends Controller
{
    protected $menuList;

    protected function _initialize()
    {
        if( !Session::get('uid','think') ){
            return $this->redirect("Login/index"); 
        }
        $user_info = User::get(['id' => Session::get('uid','think') ]);
        $service = new MenuService();
        //获取角色
        $role = $user_info->findRole;
        $this->assign('my_info',$user_info);
        $this->menuList = $service->getMenuShow($user_info);
        $this->assign('_menuList', $this->menuList );
        $super_admin = config('super_admin');

        //校验权限 ，代码需要写在权限校验之前
        if(isset($super_admin) && in_array($user_info->id,$super_admin)) {
            return true;
        }
        if(!$service->checkPermission($role->ids,$this->request->controller(),$this->request->action())){
            if($this->request->isAjax()){
                throw new HttpResponseException(json(['error'=>101,'msg'=>"没有操作权限！"]));
            }
            $this->error("没有操作权限！");
        } 
        
        
    }
    
}
