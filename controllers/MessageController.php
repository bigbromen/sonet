<?php
  include_once ROOT.'/models/Message.php';
  include_once ROOT.'/models/User.php';
  class MessageController{

    public function Index($params){
      $user = User::check_logged();
      $user_from = $user['id'];
      $iam = $user_from;
      $friend_id = $params[0];
      $messages = (Message::getMessages($iam ,$friend_id) != false) ? Message::getMessages($iam ,$friend_id) : false;
      $friend = User::show_profile($params[0]);
      $user_to = $params[0];
      if(isset($_POST['submit'])and isset($_POST['message'])){
        $message_text = $_POST['message'];
        Message::send($user_from, $user_to, $message_text);
      }
      require_once ROOT.'/views/message/index.php';
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
