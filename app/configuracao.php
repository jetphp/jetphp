<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Configurações

  Config::add('DEBUG',true);
  Config::add('md5_salt','jetphp'); // O método Criptografar::md5($valor) irá retornar um md5("SALTDEFINIDO_$valor");

  Config::add('TITULO','JetPHP');
  Config::add('PASTA_PADRAO','/');
  Config::add('PASTA_ADMIN','gerenciador/');
  Config::add('PASTA_MISC',Config::show('PASTA_PADRAO').'app/visual/misc/');
  Config::add('ADMIN_MISC',Config::show('PASTA_PADRAO').'app/visual/admin/misc/');
  Config::add('GOOGLE_ANALYTICS','');

  Config::add('PREFIXO_ADMIN','administrador_');
  Config::add('PREFIXO_SITE','site_');

  Config::add('DB_HOST','localhost');
  Config::add('DB_USUARIO','root');
  Config::add('DB_SENHA','');
  Config::add('DB_NOME','jetphp');

  Config::add('SMTP_HOST','smtp.exemplo.com');
  Config::add('SMTP_USUARIO','usuario');
  Config::add('SMTP_SENHA','senha');
  Config::add('SMTP_EMAILPRINCIPAL','email@exemplo.com');
  Config::add('SMTP_PORTA', 587);
?>
