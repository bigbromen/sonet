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
      <?php if($messages != false):?>
        <div id="block_scroll">
        <?php foreach ($messages as $message):?>
              <?php if($message['from'] == $user['id']):?>
                <div id="block_msg_iam">
                <div class="block_text_iam">
                    <p class='msg_date_iam'><span > <?php echo $message['date'];?></span></p>
                    <p><?php echo $message['text'];?></p>
                  </div>
                  <div class='avatar_mes_iam'>
                    <a href="/profile/<?php echo $user['id'];?>"><img src="<?php echo $user['avatar'];?>"></a>
                  </div>
                  <div class="clear"></div>
                  <hr>
                </div>
              <?php else:?>
                <div id="block_msg_to_me">
                  <div class='avatar_mes_to_me'>
                    <a href="/profile/<?php echo $friend['id'];?>"><img src="<?php echo $friend['avatar'];?>"></a>
                  </div>
                  <div class="block_text_to_me">
                    <p class='msg_date_to_me'><span > <?php echo $message['date'];?></span></p>
                    <p><?php echo $message['text'];?></p>
                  </div>
                  <div class="clear"></div>
                  <hr>
                </div>
              <?php endif;?>
        <?php endforeach;?>
      </div>
      <?php else:?>
        <p>Нет сообщений</p>
      <?php endif;?>
      <form action="" method="POST">
        <input type="text" name="message">
        <input type="submit" value="Отправить" name='submit'>
      </form>
    </div>
    <div class='clear'></div>
  </body>
</html>
