<?php


namespace App\services;

use Bootstrap\Facades\DB;
use Firebase\JWT\JWT;

class Auth
{
    public $userId;

    public function generateJWT($userId)
    {
        $iat = time();
        $payload = array(
            "iss" => "http://localhost:8000",
            "aud" => "http://example.com",
            "iat" => $iat,
            "exp" => $iat + \Config\Jwt::EXP,
            'sub' => $userId
        );

        return JWT::encode($payload, \Config\Jwt::SECRET, \Config\Jwt::ALGORITHM);
    }

    public function CheckJWT()
    {
        $results = new \stdClass();
        $results->isSuccessful = false;
        $results->message = null;

        $headers = apache_request_headers();
        if (!isset($headers['Authorization'])) {
            throw new \Exception('token not found !!');
        }

        $token = $headers['Authorization'];

        $decodedJWT = JWT::decode($token, \Config\Jwt::SECRET, [\Config\Jwt::ALGORITHM]);
        if ($this->userExists($decodedJWT->sub) == true)
            return $decodedJWT->sub;
    }

    private function userExists($id)
    {
        $db = (new DB())->builder;
        if ($db->recordExists('users', 'id', $id) == false) {
            throw new \Exception('user not found !!');
        }
        return true;
    }
}