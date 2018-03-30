<?php
namespace app\service;
use app\model\Menu,
    app\model\User;

class MenuService
{

    public function getFather(){
        return Menu::all([
        	'status'	=>	0,
        	'level'		=>	0
        ]);
    }
  
    public function getChild(){
        return Menu::all([
        	'status'	=>	0,
        	'level'		=>	['>',0]
        ]);
    }

    public function getMenu($ids){
        return [
            'father'    =>  Menu::all([
                'status'    =>  0,
                'level'     =>  0,
                'id'        =>  ['in',"$ids"]
            ]),
            'child'     =>  Menu::all([
                'status'    =>  0,
                'level'     =>  ['>',0],
                'id'        =>  ['in',"$ids"]
            ])
        ]; 
    }  

    public function getMenuAll(){
        return [
            'father'    =>  Menu::all([
                'status'    =>  0,
                'level'     =>  0
            ]),
            'child'     =>  Menu::all([
                'status'    =>  0,
                'level'     =>  ['>',0]
            ])
        ]; 
    } 

    public function getMenuShow($obj){
        if( $obj->id == '1' ){
            $_menuList = $this->getMenuAll();
        }else{
            $_menuList = $this->getMenu($obj->findRole->ids);
        }

        return [
            'my_info'   =>  $obj ,
            '_menuList' =>  $_menuList
        ];
    } 


}
