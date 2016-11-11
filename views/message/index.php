<?php include_once ROOT.'/views/layout/html_head.php';?>
<?php include_once ROOT.'/views/layout/header.php';?>
<script type='text/javascript' src='/components/tinny_mce/js/tinymce/tinymce.min.js'></script>

<script type='text/javascript'>
tinymce.init({
  selector: 'textarea',
  height: 50,
  width: 618,
  menubar: false,
  plugins: [
    'autolink link image emoticons media'
  ],
  language: 'ru',
  toolbar: 'link image emoticons media',
});
</script>

      <div id="profile_menu">
        <?php include_once ROOT.'/views/layout/profile_menu.php';?>
      </div>
    <div id="page_body">
      <div id="right_side_mess">
        <?php if($messages != false):?>
          <div id="block_scroll">
          <?php foreach ($messages as $message):?>
                <?php if($message['from'] == $user['id']):?>
                  <div id="block_msg_iam">
                  <div class="block_text_iam">
                      <p class='msg_date_iam'><span > <?php echo $message['date'];?></span></p>
                      <?php echo $message['text'];?>
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
                      <?php echo $message['text'];?>
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
          <textarea id="field_msg_q"></textarea>
          <input id="send_btn" type="button" value="Отправить" onclick="ajax_send_msg();">
      </div>
    </div>
    <div class='clear'></div>
<?php include_once ROOT.'/views/layout/footer.php';?>
<script>
  var count = "<?php echo count($messages);?>";
  function ajax_load_msg(){
    $.ajax({
      url: '/ajax_load_msg/',
      type: 'POST',
      timeout: 360*1000,
      data: {
        id_from: '<?php echo $user['id'];?>',
        id_to:'<?php echo $friend['id'];?>',
        count: count
      },
      success: function(data){
        var parseData = JSON.parse(data);
        count = parseData.count;
        console.log(parseData.msg);
        if(parseData.msg.from == "<?php echo $user['id'];?>"){
          $('#block_scroll').append("<div class='block_msg_iam'><div class='block_text_iam'><p class='msg_date_iam'>"+parseData.msg.date+"</p><p>"+parseData.msg.text+"</p></div><div class='avatar_mes_iam'><a href='/profile/"+parseData.msg.from+"'><img src='<?php echo $user['avatar'];?>'></a></div><div class='clear'></div> </div><hr>");
        }
        else{
          $('#block_scroll').append("<div class='block_msg_to_me'><div class='block_text_to_me'><p class='msg_date_to_me'>"+parseData.msg.date+"</p><p>"+parseData.msg.text+"</p></div><div class='avatar_mes_to_me'><a href='/profile/"+parseData.msg.to+"'><img src='<?php echo $friend['avatar'];?>'></a></div><div class='clear'></div> </div><hr>");
        }

        $("#block_scroll").scrollTop($("#block_scroll").prop('scrollHeight'));
        console.log(parseData.msg);
        setTimeout(ajax_load_msg,1000);
      },
      error: function(){
        setTimeout(ajax_load_msg,1000);
      }

    });
  }

  setInterval(ajax_load_msg, 360*1000);
  ajax_load_msg();

</script>

<script>
  function ajax_send_msg(){
    $.ajax({
      url: '/ajax_send_msg/',
      type: 'POST',
      data: {
        id_to:'<?php echo $friend['id'];?>',
        message: tinyMCE.get('field_msg_q').getContent({format : 'html'})
      },
      success: function(data){
        tinyMCE.activeEditor.setContent('');
      }
    });
  }

</script>
