<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class FormSistemaTextos extends Formulario {
    public static $nome = 'Textos estáticos';
    public static $acao = 'listar';

    public static function definirCampos() {
      self::$tabela = 'site_texto';

      self::adicionarCampo('number',['id','#'],null,'L');
      self::adicionarCampo('text',['identificador','Identificador'],'col-lg-12','LUI');
      self::adicionarCampo('textarea',['conteudo','Conteudo'],'col-lg-12','LUI');
      self::mostrarCampos();
    }
  }
?>
