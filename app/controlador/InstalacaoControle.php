<?php
  /*
  * @author João Arturscricao':
              echo "<meta name='description' content='$valor'>\n";
              break;
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class InstalacaoControle extends Controle {
    public static function index() {
      SEO::adicionar('titulo','Instalação - JetPHP');
      SEO::adicionar('descricao','JetPHP é um framework simples, cujo cunho é o desenvolvimento de sites e sistemas e geral.');
      SEO::adicionar('keywords','jetphp, joao artur');

      Carregar::view('instalar.introducao');
    }
  }
?>
