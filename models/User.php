<?php
  class User{

    public static function check_email($email){
      if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
      }
      else{
        return false;
      }
    }

    public static function check_password($password){
      if(strlen($password) >= 5){
        return true;
      }
      else{
        return false;
      }
    }

    public static function check_email_exist($email){
      $db = Db::getConnection();

      $result = $db->query("SELECT * FROM users WHERE email='$email'");
      $count_row = $result->num_rows;
      if($count_row > 0){
        return true;
      }
      else{
        return false;
      }
    }

    public static function add_user_to_db($email,$firstname,$secondname,$password,$avatar){
      $db = Db::getConnection();
      $db->query("INSERT INTO users (email, firstname, secondname, password, avatar) VALUES ('$email','$firstname','$secondname','$password','$avatar')");
      return true;
    }

    public static function check_user_to_auth($email,$password){
      $db = Db::getConnection();
      $result = $db->query("SELECT * FROM users WHERE email='$email' AND password='$password'");
      if($result->num_rows == 1){
        return true;
      }
      else {
        return false;
      }
    }

    public static function sign_in($email, $password){
      $db = Db::getConnection();
      function generateRandomString($length = 25) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
      }
      $hash = generateRandomString();

      $result = $db->query("UPDATE users SET hash='$hash' WHERE email='$email' AND password='$password'");
      if($db->affected_rows == 1){
        setcookie("hash", $hash, time()+60*60*24*30);
        setcookie("email", $email, time()+60*60*24*30);
      }
      return true;
    }

    public static function check_logged(){
      $hashCookie = $_COOKIE['hash'];
      $hashEmail = $_COOKIE['email'];
      $db = Db::getConnection();

      $result = $db->query("SELECT * FROM users WHERE hash='$hashCookie' and email='$hashEmail'");
      $user_profile = $result->fetch_array(MYSQLI_ASSOC);
      if($user_profile == NULL){
        header('Location: /authentication');
      }
      else{
        return true;
      }
    }

    public static function show_profile($id){
      $db = Db::getConnection();

      $result = $db->query("SELECT * FROM users WHERE id='$id'");
      $single_user_info = $result->fetch_array(MYSQLI_ASSOC);
      if($single_user_info == NULL){
        header('Location: /404');
      }
      else{
        return $single_user_info;
      }
    }

    public static function sign_out(){
      $hashCookie = $_COOKIE['hash'];
      $db = Db::getConnection();

      $result = $db->query("UPDATE users SET hash='false' WHERE hash='$hashCookie'");
      if($db->affected_rows == 1){
        setcookie("hash", "", time()-60*60*24*30);
        setcookie("email", "", time()-60*60*24*30);
      }
      return true;
    }
  }
