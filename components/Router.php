<?php

  class Router
  {
    private $routes;

    public function __construct()
    {
      $routes_path = ROOT.'/config/routes.php';
      $this->routes = include($routes_path);
    }

    public function run()
    {
      //Получить строку запроса
      $uri = trim($_SERVER['REQUEST_URI']);

      //Проверить наличие такого запроса в routes.php
      foreach ($this->routes as $path => $real_path) {
        if(preg_match("~$path~", $uri)){
          $intenal_route = preg_replace("~$path~", $real_path, $uri);
          $intenal_route = trim($intenal_route, '/');
          $pathes_parts = explode('/', $intenal_route);
          $controller_name = ucfirst(array_shift($pathes_parts)."Controller");
          $action_name = ucfirst(array_shift($pathes_parts));
          $params = $pathes_parts;
          //подключить файл класса контроллера
          $controller_path = ROOT.'/controllers/'.$controller_name.'.php';
          include_once($controller_path);

          //создать обьект вызвать актшон
          $obj_controller = new $controller_name;
          $result = $obj_controller -> $action_name($params);
          if($result != null){
            break;
          }
        }
      }
    }
  }
