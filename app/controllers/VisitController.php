<?php


namespace App\controllers;


class VisitController extends BaseController
{
    public function visit($request)
    {
        try {
            $link = (array)$this->DB->find('short_links', ['link'], [[
                'code', '=', $request['code']
            ]])[0];
            $url = $link['link'];
            header("Location: $url");
            echo($link['link']);
        } catch (\Exception $e) {
            echo json_encode($this->respondWithTemplate(false, null, $e->getMessage()));
        }

    }
}