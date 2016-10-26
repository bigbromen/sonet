<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>SOnET</title>
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
        <img src="<?php echo $user['avatar']?>">

      </div>
      <div id="profile_menu">
        <ul>
          <li><a href="/profile/<?php echo $user['id'];?>">Моя страница</a></li>
          <li><a href="/friends/<?php echo $user['id'];?>">Мои друзья</a></li>
          <li><a href="/messages">Мои сообщения</a></li>
          <li><a href="/profile/edit">Редактировать профиль</a></li>
        </ul>
      </div>
    </div>
    <div id="right_side">
      <div id="form_block">
        <h1>Редактировать профиль</h1>
        <form action="" method="post">
          Аватар: <input class="input_field" type="text" name="avatar" value="<?php echo $user['avatar'];?>"><br><br>
          Имя: <input class="input_field" type="text" name="firstname" value="<?php echo $user['firstname'];?>"><br><br>
          Фамили: <input class="input_field" type="text" name="secondname" value="<?php echo $user['secondname'];?>"><br><br>
          Пол:<br>
          <input class="input_r" type="radio" name="sex" value="1">Мужской<br>
          <input class="input_r" type="radio" name="sex" value="2">Женский<br><br>
          День рождения: <input class="input_field" type="text" name="birthday" value="<?php echo $user['birthday'];?>"><br><br>
          Страна: <input class="input_field" type="text" name="country" value="<?php echo $user['country'];?>"><br><br>
          Город: <input class="input_field" type="text" name="city" value="<?php echo $user['city'];?>"><br><br>
          Обо мне: <input class="input_field" type="text" name="about_me" value="<?php echo $user['about_me'];?>"><br>
          <input class="submit_field" type="submit" name="submit" value="Изменить">
        </form>
      </div>
    </div>
    <div class='clear'></div>
  </body>
</html>
