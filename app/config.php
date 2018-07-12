<?php
  \JetPHP\Model\Config::add('DEBUG',true);
  \JetPHP\Model\Config::add('md5_salt','jetphp');
  \JetPHP\Model\Config::add('TITULO','JetPHP');
  \JetPHP\Model\Config::add('PASTA_PADRAO','/');
  \JetPHP\Model\Config::add('PASTA_ADMIN','gerenciador/');
  \JetPHP\Model\Config::add('PASTA_MISC',\JetPHP\Model\Config::show('PASTA_PADRAO').'misc/');
  \JetPHP\Model\Config::add('ADMIN_MISC',\JetPHP\Model\Config::show('PASTA_PADRAO').'misc/manager/');
  \JetPHP\Model\Config::add('GOOGLE_ANALYTICS','');
  
  // Manager tables
  \JetPHP\Model\Config::add('ADMIN_SECTION','jet_sections');
  \JetPHP\Model\Config::add('ADMIN_USERS','jet_users');
  
  // Database configuration
  \JetPHP\Model\Config::add('DB_HOST','localhost');
  \JetPHP\Model\Config::add('DB_USUARIO','root');
  \JetPHP\Model\Config::add('DB_SENHA','');
  \JetPHP\Model\Config::add('DB_NOME','jetphp');
  
  // E-mail configuration
  \JetPHP\Model\Config::add('SMTP_HOST','smtp.exemplo.com');
  \JetPHP\Model\Config::add('SMTP_USUARIO','usuario');
  \JetPHP\Model\Config::add('SMTP_SENHA','senha');
  \JetPHP\Model\Config::add('SMTP_EMAILPRINCIPAL','email@exemplo.com');
  \JetPHP\Model\Config::add('SMTP_PORTA', 587);
?>
