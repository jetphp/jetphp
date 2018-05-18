<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class FormSistemaCategorias extends Formulario {
    public static $nome = 'Categorias';
    public static $acao = 'listar';

    public static function definirCampos() {
      self::$tabela = 'site_produto_categoria';
      self::adicionarCampo('number',['id','#'],null,'L');
      self::adicionarCampo('text',['nome','Nome'],'col-lg-12','LUI');
      self::mostrarCampos();
    }
  }
?>
