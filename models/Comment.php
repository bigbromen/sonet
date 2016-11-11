<?php
  class Comment{
    public static function save_comment($id_from, $id_to, $comment_body, $comment_type){
      $db = Db::getConnection();
      $db->query("SET NAMES 'utf8'");
      $arr = array();
      $ser_arr = serialize($arr);
      $res = $db->query("INSERT INTO comments
        (comment_from, comment_to, comment_body, comment_type, like_from) VALUES
        ('$id_from', '$id_to', '$comment_body', '$comment_type', '$ser_arr')
      ");
      $result = $db->query("SELECT * FROM comments WHERE comment_type='$comment_type' and comment_to='$id_to' order by date desc limit 1");
      $i=0;
      while($comments = $result->fetch_array(MYSQLI_ASSOC)){
        $from = $comments['comment_from'];
        $res = $db->query("SELECT * from users WHERE id='$from'");
        $user_from = $res->fetch_array(MYSQLI_ASSOC);
        $arr_comment[$i]['id'] = $comments['id'];
        $arr_comment[$i]['comment_from'] = $user_from['firstname'].' '.$user_from['secondname'];
        $arr_comment[$i]['comment_to'] = $comments['comment_to'];;
        $arr_comment[$i]['comment_from_avatar'] = $user_from['avatar'];
        $arr_comment[$i]['comment_body'] = $comments['comment_body'];
        $arr_comment[$i]['date'] = $comments['date'];
        $arr_comment[$i]['count_like'] = $comments['count_like'];
        $i++;
      }
      if(isset($arr_comment)) return $arr_comment;
    }

      public static function show_comment($id_to){
        $db = Db::getConnection();
        $db->query("SET NAMES 'utf8'");
        $result = $db->query("SELECT * FROM comments WHERE comment_to='$id_to' order by date desc");
        $i=0;
        while($comments = $result->fetch_array(MYSQLI_ASSOC)){
          $from = $comments['comment_from'];
          $res = $db->query("SELECT * from users WHERE id='$from'");
          $user_from = $res->fetch_array(MYSQLI_ASSOC);
          $arr_comment[$i]['id'] = $comments['id'];
          $arr_comment[$i]['comment_from'] = $user_from['firstname'].' '.$user_from['secondname'];
          $arr_comment[$i]['comment_to'] = $comments['comment_to'];;
          $arr_comment[$i]['comment_from_avatar'] = $user_from['avatar'];
          $arr_comment[$i]['comment_body'] = $comments['comment_body'];
          $arr_comment[$i]['date'] = $comments['date'];
          $arr_comment[$i]['count_like'] = $comments['count_like'];
          $i++;
        }
        if(isset($arr_comment)) return $arr_comment;
      }

      public static function add_like($from, $id){
        if(!empty($from) and !empty($id)){
          $db = Db::getConnection();
          $db->query("SET NAMES 'utf8'");
          $res = $db->query("SELECT like_from FROM comments WHERE id='$id'");
          $like_from = $res->fetch_array(MYSQLI_ASSOC);
          $unser_like_from = unserialize($like_from['like_from']);
          if(!in_array($from, $unser_like_from)){
            array_push($unser_like_from, $from);
            $ser_like_from = serialize($unser_like_from);
            $db->query("UPDATE comments SET like_from='$ser_like_from' WHERE id=$id");
            if($db->affected_rows>0){
              $db->query("UPDATE comments SET count_like = count_like+1 WHERE id=$id");
            }
          }else{
            $unser_like_from = array_flip($unser_like_from);
            unset ($unser_like_from[$from]);
            $unser_like_from = array_flip($unser_like_from);
            $ser_like_from = serialize($unser_like_from);
            $db->query("UPDATE comments SET like_from='$ser_like_from' WHERE id=$id");
            if($db->affected_rows>0){
              $db->query("UPDATE comments SET count_like=count_like-1 WHERE id=$id");
            }
          }

          $result = $db->query("SELECT count_like FRoM comments WHERE id='$id'");
          $like = $result->fetch_array(MYSQLI_ASSOC);
          return $like ;
        }
      }
  }
