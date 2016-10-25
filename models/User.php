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
      $empty_arr_to_friends = array();
      $empty_arr_to_notes = array();
      $ser_arr_to_friends = serialize($empty_arr_to_friends);
      $ser_arr_to_notes = serialize($empty_arr_to_notes);
      $db->query("INSERT INTO users (email, firstname, secondname, password, avatar,friends, notice)
      VALUES ('$email','$firstname','$secondname','$password','$avatar','$ser_arr_to_friends','$ser_arr_to_notes')");
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
      $result = $db->query("SELECT id FROM users WHERE email='$email' AND password='$password'");
      $user_id = $result->fetch_array(MYSQLI_ASSOC);
      return $user_id;
    }

    public static function check_logged(){
      if(isset($_COOKIE['hash']) and isset($_COOKIE['email'])){
        $hashCookie = $_COOKIE['hash'];
        $hashEmail = $_COOKIE['email'];
        $db = Db::getConnection();

        $result = $db->query("SELECT * FROM users WHERE hash='$hashCookie' and email='$hashEmail'");
        $user_profile = $result->fetch_array(MYSQLI_ASSOC);
        return $user_profile;
      }
      else{
        if($_SERVER['REQUEST_URI'] != '/authentication'){
          header('Location: /authentication');
        }
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

    public static function edit_profile($firstname, $secondname, $sex, $city, $country, $birthday, $about_me, $id, $avatar){
      $db = Db::getConnection();

      $db->query("UPDATE users SET
        avatar='$avatar',
        firstname='$firstname',
        secondname='$secondname',
        city='$city',
        sex='$sex',
        country='$country',
        birthday='$birthday',
        about_me='$about_me' WHERE id='$id'");

        if($db->affected_rows == 1){
          return true;
        }
    }

    public static function add_to_freinds($id_fr){
      //Сделать еще проверку существует ли такой id пользователя
      $hashCookie = $_COOKIE['hash'];
      $EmailCookie = $_COOKIE['email'];
      $db = Db::getConnection();

      $res_query = $db->query("SELECT * FROM users WHERE id='$id_fr'");
      if($res_query->num_rows == 1){
        $res = $db->query("SELECT * FROM users WHERE hash='$hashCookie' and email='$EmailCookie'");
        $user_arr = $res->fetch_array(MYSQLI_ASSOC);
        $friends = unserialize($user_arr['friends']);
        if(!in_array($id_fr, $friends)){
          array_push($friends, $id_fr);
          $friends_ser = serialize($friends);
          $db->query("UPDATE users SET friends='$friends_ser' WHERE hash='$hashCookie' and email='$EmailCookie'");
          if($db->affected_rows == 1){
            $friends_arr = $res_query->fetch_array(MYSQLI_ASSOC);
            $unser_frends_notes = unserialize($friends_arr['notice']);
            $notice = array(
              'from'=>$EmailCookie,
              'id'=> $user_arr['id'],
              'date'=> date("Y-m-d H:i:s"),
              'text'=>'Вас добавил в друзья пользователь'
            );
            array_push($unser_frends_notes, $notice);
            $ser_frends_notes = serialize($unser_frends_notes);
            $db->query("UPDATE users SET notice='$ser_frends_notes' WHERE id='$id_fr'");
          }
        }
      }
      return true;
    }

    public static function show_friends($id){
      $db = Db::getConnection();

      $result = $db->query("SELECT * FROM users WHERE id='$id'");
      $user_arr = $result->fetch_array(MYSQLI_ASSOC);
      $friends = unserialize($user_arr['friends']);
      $arrayFrends = array();
      foreach ($friends as $friend) {
        $res = $db->query("SELECT * FROM users WHERE id='$friend'");
        $res_arr = $res->fetch_array(MYSQLI_ASSOC);
        $arrayFrend = array(
          'id'=>$res_arr['id'],
          'firstname'=>$res_arr['firstname'],
          'secondname'=>$res_arr['secondname'],
          'avatar'=>$res_arr['avatar']
        );
        array_push($arrayFrends,$arrayFrend);
      }
      return $arrayFrends;
    }

    public static function is_my_friend($id){
      $db = Db::getConnection();
      $hashCookie = $_COOKIE['hash'];
      $EmailCookie = $_COOKIE['email'];

      $res = $db->query("SELECT friends FROM users WHERE hash='$hashCookie' and email='$EmailCookie'");
      $user_arr = $res->fetch_array(MYSQLI_ASSOC);
      $friends = unserialize($user_arr['friends']);
      if(in_array($id, $friends)){
        return true;
      }
      else {
        return false;
      }
    }

    public static function get_notice($id){
      $db = Db::getConnection();

      $result = $db->query("SELECT * FROM users WHERE id='$id'");
      $user_arr = $result->fetch_array(MYSQLI_ASSOC);
      $notice = unserialize($user_arr['notice']);

      return $notice;
    }
  }
