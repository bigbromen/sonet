<?php
  include_once ROOT.'/models/User.php';
  include_once ROOT.'/models/Wallpost.php';
  class UserController{

    public function Registration(){
      if(User::check_logged() != false){
        header('Location: /profile/'.User::check_logged()['id']);
      }
      $submit = "";
      $email = "";
      $firstname = "";
      $secondname = "";
      $password = "";

      if(isset($_POST['submit'])
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
      if(User::check_logged() != false){
        header('Location: /profile/'.User::check_logged()['id']);
      }
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
          $user_id = User::sign_in($email,$password);
          $id = $user_id['id'];
          header("Location: /profile/$id");
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
      $user = User::check_logged();
      $single_user_info = User::show_profile($params[0]);
      $user_friends = User::show_friends($params[0]);
      $is_my_friend;
      if(User::is_my_friend($params[0])){
        $is_my_friend = true;
      }
      else{
        $is_my_friend = false;
      }
      $wallposts = Wallpost::get_wallpost($params[0]);
      require_once ROOT.'/views/profile/index.php';
      return true;
    }

    public function Edit_profile(){
      $user = User::check_logged();

      if(isset($_POST['submit'])){
        $firstname = $_POST['firstname'];
        $secondname = $_POST['secondname'];
        $sex = $_POST['sex'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $birthday = $_POST['birthday'];
        $about_me = $_POST['about_me'];
        $avatar = $_POST['avatar'];
        $id = $user['id'];
        if(User::edit_profile($firstname, $secondname, $sex, $city, $country, $birthday, $about_me, $id, $avatar)){
          header("Location:/profile/$id");
        }
        else{
          header("Location:/profile/$id");
        }


      }
      require_once ROOT.'/views/profile/edit.php';
      return true;
    }

    public function Add_to_freinds($params){
      $user = User::check_logged();
      User::add_to_freinds($params[0]);
      header("Location:/profile/$params[0]");
      return true;
    }

    public function Show_friends($params){
      $user = User::check_logged();
      $user_friends = User::show_friends($params[0]);
      require_once ROOT.'/views/profile/friends.php';
      return true;
    }

    public function redir_to_iam(){
      $user = User::check_logged();
      $id = $user['id'];
      if(isset($id)){
        header("Location:/profile/$id");
      }
      return true;
    }
    public function show_notices(){
      $user = User::check_logged();
      $notices = User::get_notice();
      require_once ROOT.'/views/profile/notice.php';
      return true;
    }

  }
