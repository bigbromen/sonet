<?php include_once ROOT.'/views/layout/html_head.php';?>
<?php include_once ROOT.'/views/layout/header.php';?>
    <div id="profile_menu">
      <?php include_once ROOT.'/views/layout/profile_menu.php';?>
    </div>
    <div id="page_body">
      <div id="left_side" >
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
                      <?php echo  $user_friend['firstname'].' '; ?>
                    </a>
                  </div>
                </div>
                <?php $i++;
                  if($i==6) break;
                ?>
            <?php endforeach;?>
          <?php else:?>
          <h2>Нет друзей</h2>
          <?php endif; ?>
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
        <div id="wall">
          <?php echo exec('whoami'); ?>
          <h2>Записи</h2>
          <form enctype="multipart/form-data" method="POST" action="/send_post/?id_to=<?php echo $single_user_info['id'];?>">
            <input id="post_body" type="text" name="post_body">
            <input type="file" name="foto">
            <input id="post_submit" type="submit" value="Отправить" >
          </form>
            <div id="wallposts">
              <hr>
              <?php if($wallposts != NULL):?>
                <?php foreach ($wallposts as $wallpost): ?>
                  <div class="wallpost">
                    <div class="wallpost_avatar_from">
                      <img src="<?php echo $wallpost['post_from_avatar'];?>">
                    </div>
                    <p class="wallpost_from"><?php echo $wallpost['post_from'];?></p>
                    <p class="wallpost_date"><?php echo $wallpost['date'];?></p>
                    <div class='clear'></div>
                    <div class="wallpost_body">
                      <?php echo $wallpost['post_body'];?>
                      <img src="<?php echo $wallpost['post_img'];?>">
                    </div>
                    <div class="block_like">
                      <span onclick="send_like(<?php echo $wallpost['id'];?>)">Лайк</span> <span class="count_like_spn count_like_<?php echo $wallpost['id'];?>"><?php echo $wallpost['count_like'];?></span>
                    </div>
                    <div class="wall_coments" onclick="show_textarea(<?php echo $wallpost['id'] ?>);">
                      Коментировать
                    </div>
                    <div class='clear'></div>
                    <div class="coment_area owner_post_<?php echo $wallpost['id'];?>">
                      <form>
                        <textarea class="textarea_coment_<?php echo $wallpost['id'];?>"></textarea>
                        <input type="submit" value="Отправить">
                      </form>
                    </div>
                  <hr>
                </div>
                <?php endforeach; ?>
              <?php else:?>
                Записей нет
              <?php endif;?>
            </div>
        </div>
      </div>
    </div>
    <div class='clear'></div>
<?php include_once ROOT.'/views/layout/footer.php';?>
<script>
  var flag = true;
  function show_textarea(id){
    if(flag){
      $(".owner_post_" + id).show("fast", function(){
          $(".textarea_coment_" + id).focus();
      });
      flag = false;
    }else{
      $(".owner_post_" + id).hide();
      flag = true;
    }

  }
  function send_like(id){
    $.ajax({
      url: '/send_like/',
      type: 'POST',
      data: {
        id_post: id
      },
      success: function(data){
        $(".count_like_" + id).html(data);
      }
    });
  }
</script>
