
  $(".block_comment").hide();
  var flag_text_area = true;
  var flag_block_comment = true;

  function show_textarea(id){
    if(flag_text_area){
      $(".owner_post_" + id).show("fast", function(){
          $(".textarea_comment_" + id).focus();
      });
      flag_text_area = false;
    }else{
      $(".owner_post_" + id).hide();
      flag_text_area = true;
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

  function send_like_comment(id){
    $.ajax({
      url: '/send_like_comment/',
      type: 'POST',
      data: {
        id_comment: id
      },
      success: function(data){
        $(".comment_likecount_"+id).html(data);
      }
    });
  }

  function send_comment(id){
    $.ajax({
      url: '/send_comment/',
      type: 'POST',
      data: {
        id_to: id,
        body_comment: $(".textarea_comment_" + id).val(),
        comment_type: "wallpost"
      },
      success: function(data){
        $(".textarea_comment_" + id).val('');
        var parseData = JSON.parse(data);
        for(var i =0; i<parseData.length; i++){
          var div_body = "<div class='comment_body'>"+parseData[i]['comment_body']+"</div>";
          var div_from = "<div class='comment_from'>"+parseData[i]['comment_from']+"</div> <div class='clear'></div>";
          var div_ava = "<div class='comment_ava'><img src ='"+parseData[i]['comment_from_avatar']+"'></div>";
          var id_comm = parseData[i]['id'];
          var div_like = "<div class='block_like comment_like_"+id_comm+"' onclick=send_like_comment("+id_comm+")>Лайк <span class='comment_likecount_"+id_comm+"'>" + parseData[i]['count_like'] +"</span></div>";
          var div_date = "<div class='comment_date'>"+parseData[i]['date']+"</div>";
          $(".post_comment_"+ id).prepend(div_ava +div_from+ div_date+div_body+div_like+"<div class='clear'></div><hr>");
        }
      }
    });
  }

    function show_comment(id){
      if(flag_block_comment){
        $.ajax({
          url: '/show_comment/',
          type: 'POST',
          data: {
            id_to: id,
            comment_type: "wallpost"
          },
          success: function(data){

            var parseData = JSON.parse(data);
            for(var i =0; i<parseData.length; i++){
              var div_body = "<div class='comment_body'>"+parseData[i]['comment_body']+"</div>";
              var div_from = "<div class='comment_from'>"+parseData[i]['comment_from']+"</div> <div class='clear'></div>";
              var div_ava = "<div class='comment_ava'><img src ='"+parseData[i]['comment_from_avatar']+"'></div>";
              var div_date = "<div class='comment_date'>"+parseData[i]['date']+"</div>";
              var id_comm = parseData[i]['id'];
              var div_like = "<div class='block_like comment_like_"+id_comm+"' onclick=send_like_comment("+id_comm+")>Лайк <span class='comment_likecount_"+id_comm+"'>" + parseData[i]['count_like'] +"</span></div>";
              $(".post_comment_"+ id).append(div_ava +div_from+ div_date+div_body+ div_like +"<div class='clear'></div><hr>");
              $(".post_comment_"+ id).show();
              flag_block_comment = false;
            }
          }
        });
      }
      else{
        $(".post_comment_"+ id).hide();
        $(".post_comment_"+ id).html('');
        flag_block_comment = true;
      }
    }
