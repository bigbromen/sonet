<?php include_once ROOT.'/views/layout/html_head.php';?>
<?php include_once ROOT.'/views/layout/header.php';?>
    <div id="profile_menu">
      <ul>
        <?php include_once ROOT.'/views/layout/profile_menu.php';?>
    </div>
    <div id="page_body">
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
                    <a href="/profile/<?php echo $user_friend['id'];?>" class="qwerty">
                      <?php echo $user_friend['firstname'].' '; ?><?php echo $user_friend['secondname']; ?>
                    </a>
                  </div>
                  <a href="/message/<?php echo $user_friend['id'];?>">Написать писюльку</a>
                </div>
            <?php endforeach;?>
          <?php else:?>
          <h2>Нет друзей</h2>
          <?php endif; ?>

        </div>
      </div>
    </div>
    <div class='clear'></div>
<?php include_once ROOT.'/views/layout/footer.php';?>
