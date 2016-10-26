<?php
  class Message{

    public static function send($id_from, $id_to, $text){
      $db = Db::getConnection();
      $db->query("SET NAMES 'utf8'");
      $db->query("INSERT INTO messages (id_from, id_to, text) VALUES ('$id_from', '$id_to', '$text')");
    }

    public static function getMessages($iam, $friend){
      $db = Db::getConnection();
      $db->query("SET NAMES 'utf8'");
      $result = $db->query("SELECT * FROM messages WHERE
      (id_from='$iam' and id_to='$friend') or (id_from='$friend' and id_to='$iam') ORDER BY date");

      $count_row = $result->num_rows;
      $arr_messages = array();
      if($count_row > 0){
        $i=0;
        while($messages = $result->fetch_array(MYSQLI_ASSOC)){
          $arr_messages[$i]['from'] = $messages['id_from'];
          $arr_messages[$i]['to'] = $messages['id_to'];
          $arr_messages[$i]['text'] = $messages['text'];
          $arr_messages[$i]['date'] = $messages['date'];
          $i++;
        }
        return $arr_messages;
      }
      else{
        return false;
      }
    }

    public static function getAllMessages($id){
      $db = Db::getConnection();
      $db->query("SET NAMES 'utf8'");

      $result = $db->query("SELECT id_from, id_to FROM messages WHERE id_from='$id' or id_to='$id'");
      $arr_messages_id = array();
      $i=0;
      while($messages = $result->fetch_array(MYSQLI_ASSOC)){
        if($messages['id_from'] == $id){
          if(!in_array($messages['id_to'],$arr_messages_id)){
            $arr_messages_id[$i] = $messages['id_to'];
          }

        }elseif($messages['id_to'] == $id){
          if(!in_array($messages['id_from'],$arr_messages_id)){
            $arr_messages_id[$i] = $messages['id_from'];
          }
        }
        $i++;
      }
      return $arr_messages_id;
    }

    public static function getLastMessage($id_user, $id_friend){
      $db = Db::getConnection();
      $db->query("SET NAMES 'utf8'");
      $result = $db->query("SELECT * FROM messages WHERE
      (id_from='$id_user' and id_to='$id_friend') or (id_from='$id_friend' and id_to='$id_user') ORDER BY date desc limit 1");
      $message = $result->fetch_array(MYSQLI_ASSOC);
      return $message;
    }
  }
