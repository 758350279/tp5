<?php

namespace app\common\Auth;

use Firebase\JWT\JWT;

class JwtAuth
{
    // 秘钥
    private $key = 'defined-202002022020-xxxxx-key';
    // 发行人
    private $iss = 'www.test.com';
    // 受众
    private $aud = 'www';
    // 登录id
    private $uid;
    // 权限
    private $role;
    // 加密token
    private $token;
    // 解密token
    private $decodeToken;

    // 单例
    private static $instance;

    /**
     * 单例模式
     * @return JwtAuth
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 私有化构造函数
     * JwtAuth constructor.
     */
    private function __construct()
    {
    }

    /**
     * 私有化克隆函数
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    // 获取uid
    public function getUid()
    {
        return $this->uid;
    }

    // 设置uid
    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }

    // 获取role
    public function getRole()
    {
        return $this->role;
    }

    // 设置role
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    // 设置token
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    // 获取token
    public function getToken()
    {
        return (string)$this->token;
    }

    /**
     * 加密token
     * @return $this
     */
    public function encode()
    {
        $time = time();
        $params = [
            'iss' => $this->iss,
            'aud' => $this->aud,
            'iat' => $time, // 签发时间
            'nbf' => $time + 10, // 该时间段不允许操作token
            'exp' => $time + 3600 * 24 * 7, // 过期时间7天
            'uid' => $this->uid,//uid
            'role' => $this->role,//role
        ];
        $this->token = JWT::encode($params, $this->key, "HS256");
        return $this;
    }

    /**
     * 解密token
     * @param $jwt
     * @return array
     */
    public function decode($jwt)
    {
        JWT::$leeway = 60;
        $decoded = JWT::decode($jwt, $this->key, ["HS256"]);
        $this->decodeToken = (array)$decoded;
        $this->uid = $this->decodeToken['uid'];
        $this->role = $this->decodeToken['role'];
        return $this->decodeToken;
    }
}