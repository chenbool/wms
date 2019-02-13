<?php
namespace app\controller;
use think\Controller,
	think\Session,
	app\model\User,
    app\service\MenuService;

class Base extends Controller
{
    protected $menuList;

    protected function _initialize()
    {
        if( !Session::get('uid','think') ){
            return $this->redirect("Login/index"); 
        }
        $user_info = User::get(['id' => Session::get('uid','think') ]);
        //获取角色
        $role = $user_info->findRole;
        
        $service = new MenuService();
        $this->menuList = $service->getMenuShow($user_info);

        $this->assign( $this->menuList );
        
    }
    
}
