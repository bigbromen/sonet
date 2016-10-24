<?php
  include_once ROOT.'/models/User.php';

  class UserController{

    public function Registration(){
      $submit = "";
      $email = "";
      $firstname = "";
      $secondname = "";
      $password = "";

      if(isset($submit) and isset($_POST['submit'])
      and isset($_POST['email'])
      and isset($_POST['firstname'])
      and isset($_POST['secondname'])
      and isset($_POST['password'])
      ){
        $submit = $_POST['submit'];
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $secondname = $_POST['secondname'];
        $password = $_POST['password'];
        $errors = FALSE;

        if(!User::check_email($email)){
          $errors[] = "Неверный email";
        }

        if(!User::check_password($password)){
          $errors[] = "Пароль должен содержать не мение 6 символов";
        }
        if(User::check_email_exist($email)){
          $errors[] = "Email уже зарегистрирован";
        }
        if($errors == FALSE){
          $avatar = "https://image.freepik.com/free-icon/unknown-user-symbol_318-54178.jpg";
          User::add_user_to_db($email,$firstname,$secondname,$password,$avatar);
          header('Location: /authentication');
        }
      }

      require_once ROOT.'/views/user/registration.php';
      return true;
    }

    public function Auth(){
      if(isset($_POST['submit'])
      and isset($_POST['email'])
      and isset($_POST['password'])
      ){
        $submit = $_POST['submit'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors = FALSE;

        if(!User::check_user_to_auth($email,$password)){
          $errors[] = "Неверный пароль или email";
        }

        if($errors == false){
          User::sign_in($email,$password);
          header('Location: /');
        }
      }

      require_once ROOT.'/views/user/authentication.php';
      return true;
    }

    public function Sign_out(){
      if(User::sign_out()){
        header('Location: /authentication');
      }
    }

    public function Show_profile($params){
      User::check_logged();
      $single_user_info = User::show_profile($params[0]);

      require_once ROOT.'/views/profile/index.php';
      return true;
    }


  }
