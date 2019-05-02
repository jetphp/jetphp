<?php
  use JetPHP\Model\Route;
  Route::add('/','index@InicioControle');


  // Manager routes, remove only if you'll not use.
  Route::add(\JetPHP\Model\Config::show('PASTA_ADMIN').':pagina','pagina@AdministradorControle');
  Route::add(\JetPHP\Model\Config::show('PASTA_ADMIN').'','index@AdministradorControle');

  // Install route, remove after installing.
  Route::add('install','index@InstalacaoControle');
?>
