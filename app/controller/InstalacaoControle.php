<?php
  use JetPHP\Model\SEO;

  class InstalacaoControle extends Controle {
    public static function index() {
      SEO::add('titulo','Instalação - JetPHP');
      SEO::add('descricao','JetPHP é um framework simples, cujo cunho é o desenvolvimento de sites e sistemas e geral.');
      SEO::add('keywords','jetphp, joao artur');
      return self::view('instalar.introducao');
    }
  }
?>
