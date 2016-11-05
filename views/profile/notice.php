<?php include_once ROOT.'/views/layout/html_head.php';?>
<?php include_once ROOT.'/views/layout/header.php';?>
    <div id="profile_menu">
        <?php include_once ROOT.'/views/layout/profile_menu.php';?>
    </div>
    <div id="page_body">
      <div id="right_side">
        <div id="user_notice">
          <h2>Уведомления</h2>
          <?php if(!empty($notices)):?>
            <?php
              //$i=0;
              $notices = array_reverse($notices);
            ?>
            <?php foreach ($notices as $notice):?>
                <p><a href="/profile/<?php echo $notice['id'];?>"><?php echo $notice['from'];?></a>
                <?php echo $notice['text'];?>
                    в <?php echo $notice['date'];?></p>
              <?php
                //$i++;
                //if($i==40) break;
              ?>
            <?php endforeach;?>
          <?php else:?>
          <h2>Нет Уведомлений</h2>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class='clear'></div>
<?php include_once ROOT.'/views/layout/footer.php';?>
