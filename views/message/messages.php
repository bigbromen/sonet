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
          <li><a href="/messages">Мои сообщения</a></li>
          <li><a href="/profile/edit">Редактировать профиль</a></li>
        </ul>
      </div>
    </div>
    <div id="right_side">
      <h1>Ваши диалоги</h1><hr>
      <?php foreach ($friends as $friend ): ?>
          <div class="block_dialog">
            <p class="date_last_msg"><?php echo $friend['last_msg']['date'].' '; ?></p>
            <div class="about_dialog">
              <a href="/message/<?php echo $friend['user']['id']; ?>">
                <div style='width:50px;'>
                  <img src="<?php echo $friend['user']['avatar'].' '; ?>" style="width:100%;">
                </div>
                <?php echo $friend['user']['firstname'].' '; ?>
                <?php echo $friend['user']['secondname']; ?>
              </a>
            </div>
            <a href="/message/<?php echo $friend['user']['id']; ?>">
              <div class="last_msg">
              <?php echo substr($friend['last_msg']['text'],0, 120); ?>
            </div>
          </a>
          <div class='clear'></div>
        </div><hr>
      <?php endforeach; ?>
    <div class='clear'></div>
  </body>
</html>
