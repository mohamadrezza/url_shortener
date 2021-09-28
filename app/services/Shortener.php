<?php

namespace App\Services;

use App\Models\ShortLink;
use Bootstrap\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Shortener
{
    private $link;
    private $userId;
    private $shortLink;
    private $timestamp;
    public $code;

    public function setLink($link)
    {
        $this->link = $link;
    }
    public function setUserId($userId){
        $this->userId = $userId;
    }
    public function setExpiration($timestamp)
    {
        if ($timestamp != null && $timestamp < time()) {
            throw new \Exception('expiration time is not valid');
        }

        $this->timestamp = $timestamp;
    }

    private function createRecordInDb(): void
    {
        $DB = (new DB())->builder;

        $id = $DB->store('short_links', [
            'user_id' =>$this->userId ,
            'link' => $this->link,
            'code' => generateUniqueId('short_links', 'code'),
            'expire_at' => $this->timestamp != null
                ? date('Y-m-d H:i:s', $this->timestamp) : null
        ]);
        $this->shortLink =(array) $DB->find('short_links', ['*'], [[
            'id', '=', $id
        ]])[0];
    }


    public function makeItShort()
    {
        $this->createRecordInDb();
        $this->code = $this->shortLink['code'];
    }

    public function getShortLink($code)
    {

        return \Config\Shortener::DOMAIN . '/' . $code;
    }


}
