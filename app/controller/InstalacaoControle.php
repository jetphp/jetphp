<?php
  class InstalacaoControle extends Controle {
    public static function index() {
      \JetPHP\Model\SEO::add('titulo','Instalação - JetPHP');
      \JetPHP\Model\SEO::add('descricao','JetPHP é um framework simples, cujo cunho é o \JetPHP\Model\desenvolvimento de sites e sistemas e geral.');
      \JetPHP\Model\SEO::add('keywords','jetphp, joao artur');
      \JetPHP\Model\Load::view('instalar.introducao');
    }
  }
?>
