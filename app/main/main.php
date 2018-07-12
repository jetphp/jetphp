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

  include '../app/main/jetphp.php';
  include '../app/config.php';
  include '../app/route.php';
  new \JetPHP\JetPHP;

  if (\JetPHP\Model\Config::show('DEBUG')) {
    ini_set('display_errors',1);
  }


?>
