<?php

use Bootstrap\Facades\DB;
use Config\Shortener;
function generateUniqueId($table, $columnCheckUnique, $length = null): string
{
    $length = $length ?? Shortener::CODE_LENGTH;

    $id =Shortener::URL_PREFIX. substr(md5(microtime()),rand(0,26),$length);

    if (idExists($id, $table, $columnCheckUnique)) {
        return generateUniqueId($table, $columnCheckUnique);
    }

    return $id;
}

/**
 * @param $id
 * @param $table
 * @param $columnCheckUnique
 * @return boolean
 */
function idExists($id, $table, $columnCheckUnique): bool
{
    $DB=(new DB())->builder;

    return $DB->recordExists($table,$columnCheckUnique, $id);
}


function getColumns($parameters): string
{
    return implode(', ', array_keys($parameters));
}


function getValues($parameters): string
{
    return ':' . implode(', :', array_keys($parameters));
}

function generateUpdateFieldsCommand($data): string
{
    $updateFields = '';
    foreach ($data as $data => $value) {
        $updateFields .= ", $data = '$value'";
    }
    return substr($updateFields, 1);
}

