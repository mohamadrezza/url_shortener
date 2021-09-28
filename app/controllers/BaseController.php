<?php

namespace App\Controllers;


use App\services\Auth;
use Bootstrap\Facades\DB;

class BaseController
{
    protected $body, $DB, $userId;

    public function __construct()
    {
        $this->body = json_decode(file_get_contents("php://input"), true);
        header('Content-Type: application/json; charset=utf-8');
        $this->DB = (new DB())->builder;
    }

    protected function respondWithToken($token)
    {
        return [
            'ok' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
        ];
    }


    protected function respondWithTemplate($ok = false, $data = [], $msg = null, $statusCode = 200)
    {
        return [
            'ok' => $ok,
            'msg' => $msg,
            'data' => $data
        ];
    }
}
