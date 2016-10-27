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
        <input id="field_msg_q" type="text">
        <input id="send_btn" type="button" value="Отправить" onclick="ajax_send_msg_tm();">
    </div>
    <div class='clear'></div>
  </body>
</html>
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
    console.log($("#field_msg_q").val());
    $.ajax({
      url: '/ajax_send_msg/',
      type: 'POST',
      data: {
        id_to:'<?php echo $friend['id'];?>',
        message: $("#field_msg_q").val()
      },
      success: function(data){

      }
    });
  }
  function ajax_send_msg_tm(){
    setTimeout(ajax_send_msg,1100);
  }
</script>
