<?php
  include_once ROOT.'/models/Message.php';
  include_once ROOT.'/models/User.php';
  include_once ROOT.'/models/Wallpost.php';
  class WallpostController{

    public function Send_post(){
      $user = User::check_logged();
      $user_from = $user['id'];
      $user_to = $_GET['id_to'];
      $post_body = $_POST['post_body'];
      $uploaddir = ROOT.'/uploads/';
      if(!empty($post_body) or !empty($_FILES['foto']['name'])){
        if(!empty($_FILES['foto']['name'])){
          $uploadfile = $uploaddir. basename($_FILES['foto']['name']);
          if (!file_exists('upload/'. ($_FILES['foto']['name']))){
            move_uploaded_file($_FILES['foto']['tmp_name'], $uploadfile);
          }
          $img_path = "/uploads/". basename($_FILES['foto']['name']);
          Wallpost::save_post($user_from, $user_to, $post_body, $img_path);
          User::add_notice_wallpost($user_to);
          header("Location: /profile/$user_to");
        }
        else{
          $img_pathe = NULL;
          Wallpost::save_post($user_from, $user_to, $post_body, $img_path);
          User::add_notice_wallpost($user_to);
          header("Location: /profile/$user_to");
        }

      }
      else{
        header("Location: /profile/$user_to");
      }
    return true;
    }

    public function send_like(){
      $user = User::check_logged();
      $user_from = $user['id'];
      $id = $_POST['id_post'];
      echo Wallpost::add_like($user_from, $id)['count_like'];
      return true;
    }
  }
