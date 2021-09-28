<?php


namespace App\Controllers;


use App\services\Auth;
use Firebase\JWT\JWT;
use http\Header;

class AuthController extends BaseController
{
    public function register()
    {
        $service = new Auth();
        try {
            if ($this->DB->recordExists('users', 'email', $this->body['email'])) {
                throw new \Exception('sorry,email exist');
            }

            $userId = $this->DB->store('users', [
                'name' => $this->body['name'],
                'email' => $this->body['email'],
                'password' => password_hash($this->body['password'], PASSWORD_DEFAULT),
            ]);

            $token = $service->generateJWT($userId);

            echo json_encode($this->respondWithToken($token));
        } catch (\Exception $exception) {
            echo json_encode($this->respondWithTemplate(false, null, $exception->getMessage()));
        }
    }

    public function login()
    {
        $service = new Auth();

        try {
            if (!$this->DB->recordExists('users', 'email', $this->body['email'])) {
                throw new \Exception('user not found');
            }
            $user =(array) $this->DB->find('users', ['id','password'], [[
                'email', '=', $this->body['email']
            ]])[0];

            $checkPassword =  password_verify($this->body['password'], $user['password']);

            if (!$checkPassword) {
                throw new \Exception('sorry,wrong password');
            }
            $token = $service->generateJWT($user['id']);

            echo json_encode($this->respondWithToken($token));
        } catch (\Exception $e) {
            echo json_encode($this->respondWithTemplate(false, null, $e->getMessage()));
        }
    }

}