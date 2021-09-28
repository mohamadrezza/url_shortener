<?php


namespace App\Controllers;


use App\services\Auth;
use App\Services\Shortener;
use Bootstrap\Facades\DB;

class LinkController extends BaseController
{
    public function __construct()
    {
        $this->body = json_decode(file_get_contents("php://input"), true);
        header('Content-Type: application/json; charset=utf-8');
        $this->DB = (new DB())->builder;
        $this->userId = (new Auth())->CheckJWT();
    }

    public function generate()
    {
        try {
            $service = new Shortener();
            $service->setUserId($this->userId);
            $service->setLink($this->body['link']);
            $service->setExpiration($this->body['expireAt'] ?? null);
            $service->makeItShort();

            echo json_encode($this->respondWithTemplate(true, ['link' => $this->body['link'],
                'code' => $service->code,
                'shortLink' => $service->getShortLink($service->code)]));

        } catch (\Exception $e) {
            echo json_encode($this->respondWithTemplate(false, null, $e->getMessage()));
        }
    }

    public function index()
    {
        try {

            $links = (array)$this->DB->find('short_links', ['expire_at', 'code', 'link', 'id'], [[
                'user_id', '=', 20
            ]]);

            echo json_encode($this->respondWithTemplate(true, $links));
        } catch (\Exception $e) {
            echo json_encode($this->respondWithTemplate(false, null, $e->getMessage()));

        }

    }


    public function update($request)
    {
        if(isset($this->body['expire_at'])){
            $this->body['expire_at']=date('Y-m-d H:i:s', $this->body['expire_at']);
        }

        try {
            $this->DB->updateById('short_links', $request['id'], $this->body);
            echo json_encode($this->respondWithTemplate(true, null, 'updated'));
        } catch (\Exception $e) {
            return json_encode($this->respondWithTemplate(false, null, $e->getMessage()));
        }
    }

    public function delete($request)
    {
        try {
            $this->DB->deleteById('short_links', $request['id'],$this->userId);
            echo json_encode($this->respondWithTemplate(true, null, 'deleted'));
        } catch (\Exception $e) {
            return json_encode($this->respondWithTemplate(false, null, $e->getMessage()));
        }
    }


}