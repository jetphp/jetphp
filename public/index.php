<?php
  if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    include __DIR__.'/../vendor/autoload.php';
    include __DIR__.'/../app/core/autoload.php';
  } else {
    echo "You need to install dependencies using composer";
  }