<?php


namespace App\helpers\generators;


class Update
{
    public $data;

    public function setData($data)
    {
        $updateFields = '';
        foreach ($data as $data => $value) {
            $updateFields .= ", $data '= '$value'";
        }

        $this->data = rtrim($updateFields, ',');
    }

}