<?php
  use JetPHP\Model\SEO;
  class InicioControle extends Controle {     
    public static function index() {
      SEO::add('titulo','Início - JetPHP');
      SEO::add('descricao','JetPHP é um framework simples, cujo cunho é o desenvolvimento de sites e sistemas e geral.');
      SEO::add('keywords','jetphp, joao artur');

      return self::view('site.inicio');
    }
  }
?>
