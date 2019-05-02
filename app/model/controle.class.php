<?php
  class Controle {
    public static function view($caminho,$var=null,$admin=false,$menu=true) {
      if (file_exists('../vendor/autoload.php')) {
        \JetPHP\Model\Load::view($caminho,$var,$admin,$menu);
      } else {
        header('Location:'.\JetPHP\Model\Config::show('PASTA_PADRAO').'install');
      }
    }
  }
?>
