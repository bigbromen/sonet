<?php
  class Wallpost{

    public static function save_post($id_from, $id_to, $body, $uploadfile){
      $arr = array();
      $ser_arr = serialize($arr);
      $db = Db::getConnection();
      $db->query("SET NAMES 'utf8'");
      $result = $db->query("INSERT INTO wallpost
        (post_from, post_to, post_body, img_post, like_from) VALUES
        ('$id_from', '$id_to', '$body', '$uploadfile', '$ser_arr')
      ");
    }

    public static function get_wallpost($id){
      $db = Db::getConnection();
      $db->query("SET NAMES 'utf8'");
      $result = $db->query("SELECT * from wallpost WHERE post_to='$id' order by date desc");

      $i=0;
      while($posts = $result->fetch_array(MYSQLI_ASSOC)){
        $from = $posts['post_from'];
        $res = $db->query("SELECT * from users WHERE id='$from'");
        $user_from = $res->fetch_array(MYSQLI_ASSOC);
        $arr_post[$i]['id'] = $posts['id'];
        $arr_post[$i]['post_from'] = $user_from['firstname'].' '.$user_from['secondname'];
        $arr_post[$i]['post_from_avatar'] = $user_from['avatar'];
        $arr_post[$i]['post'] = $posts['post_to'];
        $arr_post[$i]['post_body'] = $posts['post_body'];
        $arr_post[$i]['date'] = $posts['date'];
        $arr_post[$i]['post_img'] = $posts['img_post'];
        $arr_post[$i]['count_like'] = $posts['count_like'];
        $i++;
      }
      if(isset($arr_post))return $arr_post;
    }

    public static function add_like($from, $id){
      if(!empty($from) and !empty($id)){
        $db = Db::getConnection();
        $db->query("SET NAMES 'utf8'");
        $res = $db->query("SELECT like_from FROM wallpost WHERE id='$id'");
        $like_from = $res->fetch_array(MYSQLI_ASSOC);
        $unser_like_from = unserialize($like_from['like_from']);
        if(!in_array($from, $unser_like_from)){
          array_push($unser_like_from, $from);
          $ser_like_from = serialize($unser_like_from);
          $db->query("UPDATE wallpost SET like_from='$ser_like_from' WHERE id=$id");
          if($db->affected_rows>0){
            $db->query("UPDATE wallpost SET count_like = count_like+1 WHERE id=$id");
          }
        }else{
          $unser_like_from = array_flip($unser_like_from);
          unset ($unser_like_from[$from]);
          $unser_like_from = array_flip($unser_like_from);
          $ser_like_from = serialize($unser_like_from);
          $db->query("UPDATE wallpost SET like_from='$ser_like_from' WHERE id=$id");
          if($db->affected_rows>0){
            $db->query("UPDATE wallpost SET count_like=count_like-1 WHERE id=$id");
          }
        }

        $result = $db->query("SELECT count_like FRoM wallpost WHERE id='$id'");
        $like = $result->fetch_array(MYSQLI_ASSOC);
        return $like ;
      }
    }

  }
