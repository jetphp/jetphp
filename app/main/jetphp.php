<?php
  namespace JetPHP {
    class JetPHP {
      public function __construct() {
        \JetPHP\Model\Route::load(\JetPHP\Model\Config::show('PASTA_PADRAO').self::rotaAtual());
      }
      public static function rotaAtual() {
        $url = explode('?',$_SERVER['REQUEST_URI']);
        $url = (\JetPHP\Model\Config::show('PASTA_PADRAO') != '/')?str_replace(\JetPHP\Model\Config::show('PASTA_PADRAO'),'',$url[0]):$url[0];
        return $url;
      }
      public static function menuAtivo($menu) {
        if (self::rotaAtual() == $menu) {
          echo 'active';
        }
      }
    }
  }
?>
