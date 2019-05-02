<?php
  use JetPHP\Model\Config;
  session_start();
  $phpv = phpversion();
  if ($phpv < 7) {
    echo "Your PHP version is lower than 7. Your version: $phpv";
    die;
  }
  foreach (glob('../app/model/*.class.php') as $file) {
    include $file;
  }
  include '../app/main/jetphp.php';
  include '../app/config.php';
  include '../app/route.php';

  new \JetPHP\JetPHP();

  if (Config::show('DEBUG')) {
    ini_set('display_errors',1);
  }
?>
