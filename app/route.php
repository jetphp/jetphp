<?php
  // Routes

  \JetPHP\Model\Route::add('/','index@InicioControle');

  // Gerenciador - não remover
  \JetPHP\Model\Route::add(\JetPHP\Model\Config::show('PASTA_ADMIN').':pagina','pagina@AdministradorControle');
  \JetPHP\Model\Route::add(\JetPHP\Model\Config::show('PASTA_ADMIN').'','index@AdministradorControle');

  // Route de instalação, remover após instalar
  \JetPHP\Model\Route::add('instalacao','index@InstalacaoControle');
?>
