<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Rotas

  Rota::adicionar('/','index@InicioControle');

  // Gerenciador - não remover
  Rota::adicionar(Config::mostrar('PASTA_ADMIN').':pagina','pagina@AdministradorControle');
  Rota::adicionar(Config::mostrar('PASTA_ADMIN').'','index@AdministradorControle');

  // Rota de instalação, remover após instalar
  Rota::adicionar('instalacao','index@InstalacaoControle');


  Rota::adicionar('docs/:titulo/:pagina', 'index@DocsControle');
  Rota::adicionar('docs/', 'redirecionar@DocsControle');

  Rota::adicionar('captchaGerar', 'captcha@AdministradorControle');
?>
