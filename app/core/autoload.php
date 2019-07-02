<?php
  use JetPHP\Model\Config;
  session_start();
  $phpv = phpversion();
  if ($phpv < 7) {
    echo "Your PHP version is lower than 7. Your version: $phpv";
    die;
  }

  // Framework models
  foreach (glob(__DIR__.'/model/*.php') as $file) {
    include $file;
  }

  // User models
  foreach (glob(__DIR__.'/../model/*.php') as $file) {
    include $file;
  }
  include __DIR__.'/jetphp.php';
  include __DIR__.'/../config.php';
  include __DIR__.'/../route.php';

  new \JetPHP\JetPHP();

  if (Config::show('DEBUG')) {
    ini_set('display_errors',1);
  }
?>
