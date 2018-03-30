<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class InicioControle extends Controle {
    public static function index() {
      SEO::adicionar('titulo','Início - JetPHP');
      SEO::adicionar('descricao','JetPHP é um framework simples, cujo cunho é o desenvolvimento de sites e sistemas e geral.');
      SEO::adicionar('keywords','jetphp, joao artur');

      if (file_exists('vendor/autoload.php')) {
        Carregar::view('site.inicio');
      } else {
        header('Location:'.Config::show('PASTA_PADRAO').'instalacao');
      }
    }
  }
?>
