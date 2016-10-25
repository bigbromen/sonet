<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>HTML5</title>
    <link href='/temp/css/style.css' rel="stylesheet" type="text/css">
  </head>
  <body>
    <header>
      <h1 style="margin-top: 0px;">SoNet</h1>
    </header>
    <div id="block_1">
      <h2>Будьте в сети и общайтесь с друзьями с любого устройства</h2>
      <img src="/temp/img/preview.png">
    </div>
    <div id="form_block">
      <h1>Выполните вход <BR>в Sonet или <a href="registration">зарегистрируйтесь</a></h1>
      <form action="" method="post">
        <input class="input_field" type="text" name="email" placeholder="Е-mail"><br>
        <input class="input_field" type="password" name="password" placeholder="Пароль"><br>
        <input class="submit_field" type="submit" name="submit" value="Войти">
      </form>
      <?php
      if(isset($errors) and is_array($errors)){
        foreach ($errors as $erros) {
          echo "$erros <br>";
        }
      }
      ?>
    </div>
  </body>
</html>
