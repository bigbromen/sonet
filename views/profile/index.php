<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>HTML5</title>
    <link href='/temp/css/style.css' rel="stylesheet" type="text/css">
  </head>
  <body>
    <header>
      <h1 style="margin-top: 0px; float: left;">SoNet</h1>

      <a href="/sign_out" class="btn_out" style="display: inline-block; float:right; ">Выйти</a>
    </header>
    <div class='clear'></div>
    <div id="left_side">
      <div id="profile_img">
        <img src="<?php echo $single_user_info['avatar']?>">
        <a href=""><div class="btn_fre_mes">Написать сообщение</div></a>
        <a href=""><div class="btn_fre_mes">Добавить в друзья</div></a>
      </div>
      <div id="profile_menu">
        <ul>
          <li><a href="">Моя страница</a></li>
          <li><a href="">Мои друзья</a></li>
          <li><a href="">Мои сообщения</a></li>
          <li><a href="">Редактировать профиль</a></li>
        </ul>
      </div>
    </div>
    <div id="right_side">
      <div id="about">
        <h2 id='user_name' class="about_user"><?php echo $single_user_info['firstname']." ".$single_user_info['secondname'];?></h2>
        <p class="about_user">Дата рождения: </p>
        <p class="about_user">Пол: </p>
        <p class="about_user">Страна: </p>
        <p class="about_user">Город: </p>
        <p class="about_user">О себе: </p>
      </div>
      <div id="user_friend">
        <h2>Друзья</h2>
      </div>
    </div>
    <div class='clear'></div>
  </body>
</html>
