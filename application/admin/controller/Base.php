<?php

namespace app\admin\controller;

use app\common\Auth\JwtAuth;
use think\Controller;

header("Access-Control-Allow-Credentials:true");
header('Access-Control-Allow-Origin:*');

class Base extends Controller
{
    protected $uid;
    protected $role;

    public function __construct()
    {
        $token = input('token');
        $jwt = JwtAuth::getInstance();
        $this->uid = $jwt->setToken($token)->getUid();
        $this->role = $jwt->setToken($token)->getRole();

        parent::__construct();
    }
}