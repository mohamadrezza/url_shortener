<?php

//links
$router->post('links/generate','LinkController@generate');
$router->get('links/{id}/delete','LinkController@delete');
$router->post('links/{id}/update','LinkController@update');
$router->get('links','LinkController@index');


//visit code
$router->get('{code}','VisitController@visit');


//auth
$router->post('register','AuthController@register');
$router->post('login','AuthController@login');
