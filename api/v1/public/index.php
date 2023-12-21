<?php

require '../core/Router.php';
require '../app/controllers/Media.php';

echo 'Bienvenid@ al API de MEDIA! <br>';
$url = $_SERVER['QUERY_STRING'];
echo 'URL = ' . $url . '<br>';

$router = new Router();

//ENDPOINTS DE MEDIA
$router->add(
    '/public/media/get',
    array(         //GET para todos los media
        'controller' => 'Media',
        'action' => 'getAllMedia'
    )
);
$router->add(
    '/public/media/get/{id}',
    array(    //GET para un medio
        'controller' => 'Media',
        'action' => 'getMediaById'
    )
);
$router->add(
    '/public/media/create',
    array(      //POST para un medio
        'controller' => 'Media',
        'action' => 'createMedia'
    )
);
$router->add(
    '/public/media/update/{id}',
    array(    //PUT para un medio
        'controller' => 'Media',
        'action' => 'updateMedia'
    )
);
$router->add(
    '/public/media/delete/{id}',
    array(    //DELETE para un medio
        'controller' => 'Media',
        'action' => 'deleteMedia'
    )
);
/*
$router->add(
    '/public/media/kk',
    array(    //404 para un medio
        'controller' => 'Media',
        'action' => 'errorMedia'
    )
);
*/
//var_dump($router);

$urlParams = explode('/', $url); //separa en parámetros la url a través de la /

$urlArray = array(
    'HTTP' => $_SERVER['REQUEST_METHOD'],
    'path' => $url,       //url que viene por el navegador para comprobar en el router
    'controller' => '',
    'action' => '',
    'params' => ''
);

//hacemos una validación de que lo que nos entra por el navegador es lo que queremos
//No nos interesa que el controlador venga vacío

if (!empty($urlParams[2])) {
    $urlArray['controller'] = ucwords($urlParams[2]);
    if (!empty($urlParams[3])) {
        $urlArray['action'] = $urlParams[3];
        if (!empty($urlParams[4])) {
            $urlArray['params'] = $urlParams[4];
        }
    } else {
        $urlArray['action'] = 'index';
    }
} else {                                  //Si el controlador viene vacio
    $urlArray['controller'] = 'Home';     //Controladores con mayúsculas (Clases)
    $urlArray['action'] = 'index';        //Métodos en minúsculas
}

//Verifica el método HTTP de la solicitud
$method = $_SERVER['REQUEST_METHOD'];

//Define los parámetros según el método HTTP
$params = [];

if ($router->matchRoutes($urlArray)) {
    if ($method === 'GET') {

        $params[] = intval($urlArray['params']) ?? null;
    } elseif ($method === 'POST') {

        $json = file_get_contents('php://input'); //lee el json del body http
        $params[] = json_decode($json, true);
    } elseif ($method === 'PUT') {

        $id = intval($urlArray['params']) ?? null;
        $json = file_get_contents('php://input'); //lee el json del body http
        $params[] = $id;
        $params[] = json_decode($json, true);
    } elseif ($method === 'DELETE') {

        $params[] = intval($urlArray['params']) ?? null;
    } 

    $controller = $router->getParams()['controller'];    //controlador a llamar
    $action = $router->getParams()['action'];             //método a llamar
    $controller = new $controller();

    if (method_exists($controller, $action)) {
        $resp = call_user_func_array([$controller, $action], $params);
    } else {
        echo "El metodo no existe";
    }
} 

//echo '<pre>';
//print_r($urlArray) .'<br>';
//print_r($router->getRoutes()) .'<br>'; //muestra las rutas introducidas
//print_r($method) .'<br>';
//echo '</pre>';
?>