<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Rotas

  Rota::adicionar('/','index@InicioControle');
  
  Rota::adicionar(Config::mostrar('PASTA_ADMIN').':pagina','pagina@AdministradorControle');
  Rota::adicionar(Config::mostrar('PASTA_ADMIN').'','index@AdministradorControle');
?>
