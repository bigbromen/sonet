<?php
  return array(
    "ajax_load_msg"=>"message/ajax_load_msg",
    "send_post"=>"wallpost/send_post/$1 ",
    "send_like"=>"wallpost/send_like/$1 ",
    "ajax_send_msg"=>"message/ajax_send_msg",
    "messages"=>"message/Show_messages",
    "/message/([0-9]+)"=>"/message/index/$1",
    "/profile/([0-9]+)"=>"user/show_profile/$1",
    "/friends/([0-9]+)"=>"user/show_friends/$1",
    "/add_freinds/([0-9]+)"=>"user/add_to_freinds/$1",
    "/notice"=>"user/show_notices",
    "registration"=>"user/registration",
    "authentication"=>"user/auth",
    "sign_out"=>"user/sign_out",
    "profile/edit"=>"user/edit_profile",
    "/"=>"user/redir_to_iam/"
  );
