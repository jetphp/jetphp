<?php
  namespace JetPHP;
  class JetPHP {
    public function __construct() {
      Route::load(Config::show('PASTA_PADRAO').self::rotaAtual());
    }
    public static function rotaAtual() {
      $url = explode('?',$_SERVER['REQUEST_URI']);
      $url = (Config::show('PASTA_PADRAO') != '/')?str_replace(Config::show('PASTA_PADRAO'),'',$url[0]):$url[0];
      return $url;
    }
    public static function menuAtivo($menu) {
      if (self::rotaAtual() == $menu) {
        echo 'active';
      }
    }
  }
?>
