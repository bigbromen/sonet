  <?php include_once ROOT.'/views/layout/html_head.php';?>
  <?php include_once ROOT.'/views/layout/header.php';?>
    <div id="profile_menu">
        <?php include_once ROOT.'/views/layout/profile_menu.php';?>
    </div>
    <div id="page_body">
    <div id="right_side">
      <h1>Ваши диалоги</h1><hr>
      <?php echo "<pre>";print_r($friends);echo "</pre>";?>
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
  </div>
<?php include_once ROOT.'/views/layout/footer.php';?>
