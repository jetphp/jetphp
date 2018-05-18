<?php
  Config::add('DEBUG',true);
  Config::add('md5_salt','jetphp');
  Config::add('TITULO','JetPHP');
  Config::add('PASTA_PADRAO','/');
  Config::add('PASTA_ADMIN','gerenciador/');
  Config::add('PASTA_MISC',Config::show('PASTA_PADRAO').'app/view/misc/');
  Config::add('ADMIN_MISC',Config::show('PASTA_PADRAO').'app/view/admin/misc/');
  Config::add('GOOGLE_ANALYTICS','');
  
  // Manager tables
  Config::add('ADMIN_SECTION','jet_sections');
  Config::add('ADMIN_USERS','jet_users');
  
  // Database configuration
  Config::add('DB_HOST','localhost');
  Config::add('DB_USUARIO','root');
  Config::add('DB_SENHA','');
  Config::add('DB_NOME','jetphp');
  
  // E-mail configuration
  Config::add('SMTP_HOST','smtp.exemplo.com');
  Config::add('SMTP_USUARIO','usuario');
  Config::add('SMTP_SENHA','senha');
  Config::add('SMTP_EMAILPRINCIPAL','email@exemplo.com');
  Config::add('SMTP_PORTA', 587);
?>
