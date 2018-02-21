<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Configurações

  Config::adicionar('DEBUG',true);
  Config::adicionar('md5_salt','jetphp'); // O método Criptografar::md5($valor) irá retornar um md5("SALTDEFINIDO_$valor");

  Config::adicionar('TITULO','JetPHP');
  Config::adicionar('PASTA_PADRAO','/');
  Config::adicionar('PASTA_ADMIN','gerenciador/');
  Config::adicionar('PASTA_MISC',Config::mostrar('PASTA_PADRAO').'app/visual/misc/');
  Config::adicionar('ADMIN_MISC',Config::mostrar('PASTA_PADRAO').'app/visual/admin/misc/');
  Config::adicionar('GOOGLE_ANALYTICS','');

  Config::adicionar('PREFIXO_ADMIN','administrador_');
  Config::adicionar('PREFIXO_SITE','site_');

  Config::adicionar('DB_HOST','localhost');
  Config::adicionar('DB_USUARIO','root');
  Config::adicionar('DB_SENHA','');
  Config::adicionar('DB_NOME','jetphp');

  Config::adicionar('SMTP_HOST','smtp.exemplo.com');
  Config::adicionar('SMTP_USUARIO','usuario');
  Config::adicionar('SMTP_SENHA','senha');
  Config::adicionar('SMTP_EMAILPRINCIPAL','email@exemplo.com');
  Config::adicionar('SMTP_PORTA', 587);
?>
