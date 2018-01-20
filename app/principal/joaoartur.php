<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class JoaoArtur {

    public function __construct() {
      Rota::carregar(Config::mostrar('PASTA_PADRAO').self::rotaAtual());
    }

    public static function rotaAtual() {
      $url = explode('?',$_SERVER['REQUEST_URI']);
      $url = (Config::mostrar('PASTA_PADRAO') != '/')?str_replace(Config::mostrar('PASTA_PADRAO'),'',$url[0]):$url[0];
      return $url;
    }

    public static function menuAtivo($menu) {
      if (self::rotaAtual() == $menu) {
        echo 'active';
      }
    }

  }
?>
