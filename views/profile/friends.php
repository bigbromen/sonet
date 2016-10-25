<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>SOnET</title>
    <link href='/temp/css/style.css' rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  </head>
  <body>
    <header>
      <h1 style="margin-top: 0px; float: left;">SoNet</h1>

      <a href="/sign_out" class="btn_out" style="display: inline-block; float:right; ">Выйти</a>
    </header>
    <div class='clear'></div>
    <div id="left_side">
      <div id="profile_menu">
        <ul>
          <li><a href="/profile/<?php echo $user['id'];?>">Моя страница</a></li>
          <li><a href="/friends/<?php echo $user['id'];?>">Мои друзья</a></li>
          <li><a href="">Мои сообщения</a></li>
          <li><a href="/profile/edit">Редактировать профиль</a></li>
        </ul>
      </div>
    </div>
    <div id="right_side">
      <h1>Друзья</h1>
      <div id="section_show_friends">
        <?php if(!empty($user_friends)):?>
          <?php foreach ($user_friends as $user_friend):?>
              <div class="block_for_friend">
                <div class="img_friend">
                  <img src="<?php echo $user_friend['avatar']; ?>">
                </div>
                <div class="name_friend">
                  <a href="/profile/<?php echo $user_friend['id'];?>">
                    <?php echo $user_friend['firstname'].' '; ?><?php echo $user_friend['secondname']; ?>
                  </a>
                </div>
              </div>
          <?php endforeach;?>
        <?php else:?>
        <h2>Нет друзей</h2>
        <?php endif; ?>

      </div>
    </div>
    <div class='clear'></div>
  </body>
</html>
