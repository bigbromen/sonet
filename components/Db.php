<?php
class Db{

  public static function getConnection(){
    $params = include(ROOT.'/config/db_config.php');
    $db = new mysqli($params['host'], $params['user'], $params['password'], $params['db_name']);

    return $db;
  }

}
