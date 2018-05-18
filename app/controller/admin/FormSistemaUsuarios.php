<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class FormSistemaUsuarios extends Formulario {
    public static $nome = 'Usuários';

    public static function definirCampos() {
      self::$tabela = 'administrador_usuarios';
      self::$where  = 'nivel >= '.Admin::mostrar('nivel');

      self::adicionarCampo('number',['id','#'],null,'L');
      self::adicionarCampo('text',['nome','Nome'],'col-lg-12','LUI');
      self::adicionarCampo('select',['nivel','Nível','administrador_nivel'],'col-lg-12','UI');
      self::adicionarCampo('text',['usuario','Usuário'],'col-lg-12','LUI');
      self::adicionarCampo('text',['email','E-mail'],'col-lg-12','LUI');
      self::adicionarCampo('password',['senha','Senha'],'col-lg-12','UI');
      self::adicionarCampo('boleano',['ativo','Ativo'],'col-lg-12','UI');

      self::mostrarCampos();
    }
  }
?>
