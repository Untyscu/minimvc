<?php
class Route{
  public static function start(){
    /*
    * Set the default property of controller and action
    */
    $controllerName = 'Main';
    $action = "start";

    $routes = explode('/', $_SERVER['REQUEST_URI']);
    /*
    * Get controller name and action name
    */
    if(!empty($routes[1])){
      $controllerName = ucwords($routes[1]);
    }
    /*
    * Add prefix
    */
    $modelName = $controllerName . 'Model';
    $controllerName = $controllerName . 'Controller';
    
    $modelFile = $modelName.'.php';
    $modelPath = "models/".$modelFile;

    if(file_exists($modelPath)){
      include "models/".$modelFile;
    }
    $controllerFile = $controllerName.'.php';
    $controllerPath = "controllers/".$controllerFile;

    if(file_exists($controllerPath)){
      include "controllers/".$controllerFile;
    }
    else{
      Route::Error404();
    }

    $controller = new $controllerName;

    if(method_exists($controller, $action)){
      $controller->$action();
    }else{
      Route::Error404();
    }
  }
  public function Error404(){
    $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');
    header('Location:'.$host.'404');
  }
}
