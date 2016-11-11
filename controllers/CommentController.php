<?php

  class CommentController{
    public function send_comment(){
      $user = User::check_logged();
      $user_from = $user['id'];
      $comment_to = $_POST['id_to'];
      $comment_body = $_POST['body_comment'];
      $comment_type = $_POST['comment_type'];
      echo json_encode(Comment::save_comment($user_from, $comment_to, $comment_body, $comment_type));

      return true;
    }

    public function show_comment(){
      $user = User::check_logged();
      $comment_to = $_POST['id_to'];
      echo json_encode(Comment::show_comment($comment_to));

      return true;
    }

    public function send_like_comment(){
      $user = User::check_logged();
      $user_from = $user['id'];
      $id = $_POST['id_comment'];
      echo Comment::add_like($user_from, $id)['count_like'];
      return true;
    }
  }
