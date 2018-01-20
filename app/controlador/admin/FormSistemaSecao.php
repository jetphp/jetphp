<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class FormSistemaSecao extends Formulario {
    public static $nome = 'Seções';
    public static $acao = 'listar';

    public static function definirCampos() {
      self::$tabela = 'administrador_secao';
      self::$where = 'nivel >= '.Admin::mostrar('nivel');
      self::adicionarCampo('number',['id','#'],null,'L');
      self::adicionarCampo('text',['nome','Nome'],'col-lg-12','LUI');
      self::adicionarCampo('text',['nivel','Nivel'],'col-lg-12','LUI');
      self::adicionarCampo('text',['pagina','Pagina'],'col-lg-12','UI');
      self::adicionarCampo('text',['controle','Controle'],'col-lg-12','UI');
      self::adicionarCampo('text',['icone','Icone'],'col-lg-12','LUI');
      self::adicionarCampo('number',['ordem','Ordem'],'col-lg-12','LUI');
      self::mostrarCampos();
    }
  }
?>
