<?php
  use JetPHP\Model\SEO;
  class InicioControle {     
    public static function index() {
      SEO::add('titulo','Início - JetPHP');
      SEO::add('descricao','JetPHP é um framework simples, cujo cunho é o desenvolvimento de sites e sistemas e geral.');
      SEO::add('keywords','jetphp, joao artur');

      $jl = new \JetPHP\Model\JetLoad();
      $jl->setTop('inc.topo');
      $jl->setMenu('inc.menu');
      $jl->setFooter('inc.rodape');
      $jl->view('site.inicio');
    }
  }
?>
