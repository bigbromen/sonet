<?php include_once ROOT.'/views/layout/html_head.php';?>
<?php include_once ROOT.'/views/layout/header.php';?>
    <div id="profile_menu">
        <?php include_once ROOT.'/views/layout/profile_menu.php';?>
    </div>
    <div id="page_body">>
      <div id="right_side">
        <div id="form_block">
          <h1>Редактировать профиль</h1>
          <form action="" method="post">
            Аватар: <input class="input_field" type="text" name="avatar" value="<?php echo $user['avatar'];?>"><br><br>
            Имя: <input class="input_field" type="text" name="firstname" value="<?php echo $user['firstname'];?>"><br><br>
            Фамили: <input class="input_field" type="text" name="secondname" value="<?php echo $user['secondname'];?>"><br><br>
            Пол:<br>
            <input class="input_r" type="radio" name="sex" value="1">Мужской<br>
            <input class="input_r" type="radio" name="sex" value="2">Женский<br><br>
            День рождения: <input class="input_field" type="text" name="birthday" value="<?php echo $user['birthday'];?>"><br><br>
            Страна: <input class="input_field" type="text" name="country" value="<?php echo $user['country'];?>"><br><br>
            Город: <input class="input_field" type="text" name="city" value="<?php echo $user['city'];?>"><br><br>
            Обо мне: <input class="input_field" type="text" name="about_me" value="<?php echo $user['about_me'];?>"><br>
            <input class="submit_field" type="submit" name="submit" value="Изменить">
          </form>
        </div>
      </div>
    </div>
    <div class='clear'></div>
<?php include_once ROOT.'/views/layout/footer.php';?>
