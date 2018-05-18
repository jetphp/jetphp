<?php
  session_start();

  foreach (glob('../app/model/*.class.php') as $arquivo) {
    include $arquivo;
  }

  include '../app/config.php';
  include '../app/route.php';
  include '../app/main/jetphp.php';

  if (Config::show('DEBUG')) {
    ini_set('display_errors',1);
  }


  new JetPHP;
?>
