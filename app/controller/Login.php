<?php
namespace app\controller;
use think\Controller,
    app\service\LoginService;

class Login extends Controller
{

    protected $service;
    public function __construct(LoginService $service)
    {
        parent::__construct();
        $this->service = $service;
    }  

    public function index()
    {
        return view();
    }

    public function login()
    {
        return $this->service->login();
    }

    public function quit()
    {
        $this->service->quit();
        return $this->redirect("Login/index"); 
    }

}
