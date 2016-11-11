<?php
  class MessageController{

    public function Ajax_load_msg(){
      $limit = 360;
      $time = time();
      set_time_limit($limit+5);
      while (time()-$time<$limit) {
        $user = User::check_logged();
        $iam = $user['id'];
        $id_to = $_POST['id_to'];
        $count = $_POST['count'];

        $messages = Message::getMessages($iam ,$id_to);
        if(count($messages) != $count){
          $result = array(
            'msg'=> end($messages),
            'count'=> count($messages)
          );
          json_encode($result);
          echo json_encode($result);
          flush();
          exit;
        }
        sleep(1);
      }
      return true;
    }

    public function Index($params){

      $user = User::check_logged();
      $user_from = $user['id'];
      $iam = $user_from;
      $friend_id = $params[0];
      $messages = (Message::getMessages($iam ,$friend_id) != false) ? Message::getMessages($iam ,$friend_id) : false;
      $friend = User::show_profile($params[0]);

      require_once ROOT.'/views/message/index.php';
      return true;
    }

    public function Ajax_send_msg(){
      $user = User::check_logged();
      $user_from = $user['id'];
      $user_to = $_POST['id_to'];
      $message_text = $_POST['message'];
      if(!empty($message_text)){
        Message::send($user_from, $user_to, $message_text);
        User::add_notice_msg($user_to);
      }
      echo $message_text;
      return true;
    }

    public function Show_messages(){
      $user = User::check_logged();
      $messages_id = Message::getAllMessages($user['id']);
      $friends = array();
      $i = 0;
      foreach ($messages_id as $message_id) {
        $friends[$i]['user'] = User::show_profile($message_id);
        $friends[$i]['last_msg'] = Message::getLastMessage($user['id'],$message_id);
        $i++;
      }
      require_once ROOT.'/views/message/messages.php';
      return true;
    }
  }
