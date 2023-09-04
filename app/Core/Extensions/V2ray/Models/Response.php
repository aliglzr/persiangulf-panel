<?php

namespace App\Core\Extensions\V2ray\Models;

use Exception;
use JetBrains\PhpStorm\Pure;

class Response
{
    public bool $success;
    public ?string $message;
    public mixed $object;

    public function __construct($success, $message, $object)
    {
        $this->success = $success;
        $this->message = $message;
        $this->object = $object;
    }

    public static function fromResponse(string $json): ?Response
    {
        $response = json_decode($json, true);
        try {
            if($response['msg'] == "数据格式错误") {
                $response['msg'] = "Data format error!";
            } else if($response['msg'] == "登录成功") {
                $response['msg'] = "Login successful!";
            } else if($response['msg'] == "请输入用户名") {
                $response['msg'] = "Please enter user name!";
            } else if($response['msg'] == "用户名或密码错误") {
                $response['msg'] = "Wrong user name or password!";
            } else if($response['msg'] == "添加成功") {
                $response['msg'] = "Added successfully";
            } else if($response['msg'] == "登录时效已过，请重新登录") {
                $response['msg'] = "The login time limit has expired, please log in again!";
            } else if(mb_strpos($response['msg'], "添加失败: 端口已存在") !== false) {
                $response['msg'] = "Add failed: Port already exists:" . explode(':', $response['msg'])[2];
            }

            $response['msg'] = ($response['msg'] == "") ? null : $response['msg'];
            return new Response($response['success'], $response['msg'], $response['obj']);
        } catch (Exception $e) {

        }
        return null;
    }
}
