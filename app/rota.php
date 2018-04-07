<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Routes

  Route::add('/','index@InicioControle');

  // Gerenciador - não remover
  Route::add(Config::show('PASTA_ADMIN').':pagina','pagina@AdministradorControle');
  Route::add(Config::show('PASTA_ADMIN').'','index@AdministradorControle');

  // Route de instalação, remover após instalar
  Route::add('instalacao','index@InstalacaoControle');
?>
