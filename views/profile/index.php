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
      <div id="profile_img">
        <img src="<?php echo $single_user_info['avatar']?>">
        <?php if($single_user_info['id'] != $user['id']):?>
          <a href="/message/<?php echo $single_user_info['id'];?>"><div class="btn_fre_mes">Написать сообщение</div></a>
          <?php if($is_my_friend != true):?>
            <a href="/add_freinds/<?php echo $single_user_info['id'];?>">
              <div class="btn_fre_mes">Добавить в друзья</div>
            </a>
          <?php else:?>
            <div class="btn_fre_mes">Ваш друг</div>
          <?php endif;?>
        <?php endif;?>

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
      <div id="about">
        <h2 id='user_name' class="about_user"><?php echo $single_user_info['firstname']." ".$single_user_info['secondname'];?></h2>
        <p class="about_user">Дата рождения: <?php
          if($single_user_info['birthday'] <> '2000-10-10'){
            echo $single_user_info['birthday'];
          }
         ?></p>
        <p class="about_user">Пол:
        <?php
          if($single_user_info['sex'] == 1)
          {echo "Мужской";}
          elseif($single_user_info['sex'] == 2)
          {echo "Женский";}
        ?>
      </p>
        <p class="about_user">Страна: <?php echo $single_user_info['country'];?></p>
        <p class="about_user">Город: <?php echo $single_user_info['city'];?></p>
        <p class="about_user">О себе: <?php echo $single_user_info['about_me'];?></p>
      </div>
      <hr>
      <div id="user_friend">

        <h2><a href="/friends/<?php echo $single_user_info['id'];?>">Друзья</a></h2>
        <?php if(!empty($user_friends)):?>
          <?php $i=0;?>
          <?php foreach ($user_friends as $user_friend):?>
              <div class="ind_for_friend">
                <div class="ind_img_friend">
                  <img src="<?php echo $user_friend['avatar']; ?>">
                </div>
                <div class="ind_name_friend">
                  <a href="/profile/<?php echo $user_friend['id'];?>">
                    <?php echo  $user_friend['firstname'].' '; ?><?php echo $user_friend['secondname']; ?>
                  </a>
                </div>
              </div>
              <?php $i++;
                if($i==4) break;
              ?>
          <?php endforeach;?>
        <?php else:?>
        <h2>Нет друзей</h2>
        <?php endif; ?>
      </div>
      <div id="user_notice">
        <h2>Уведомления</h2>
        <?php if(!empty($notices)):?>
          <?php $i=0;?>
          <?php foreach ($notices as $notice):?>
              <p><a href="/profile/<?php echo $notice['id'];?>"><?php echo $notice['from'];?></a>
              <?php echo $notice['text'];?>
                  в <?php echo $notice['date'];?></p>
            <?php $i++;
              if($i==5) break;
            ?>
          <?php endforeach;?>
        <?php else:?>
        <h2>Нет Уведомлений</h2>
        <?php endif; ?>
      </div>
    </div>
    <div class='clear'></div>
  </body>
</html>
