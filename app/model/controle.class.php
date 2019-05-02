<?php
  use JetPHP\Model\Route;
  use JetPHP\Model\Load;
  use JetPHP\Model\Config;

  class Controle {
    public static function view($caminho,$var=null,$admin=false,$menu=true) {
      if (file_exists('../vendor/autoload.php')) {
        Load::view($caminho,$var,$admin,$menu);
      } else {
        header('Location:'.Config::show('PASTA_PADRAO').'install');
      }
    }
  }
?>
