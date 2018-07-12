<?php
  session_start();

  $phpv = phpversion();
  if ($phpv < 7) {
    echo "A versão do PHP deve ser acima da 7. Versão atual: $phpv";
    die;
  }

  foreach (glob('../app/model/*.class.php') as $arquivo) {
    include $arquivo;
  }

  include '../app/config.php';
  include '../app/route.php';
  include '../app/main/jetphp.php';

  if (Config::show('DEBUG')) {
    ini_set('display_errors',1);
  }


  new \JetPHP\JetPHP;
?>
