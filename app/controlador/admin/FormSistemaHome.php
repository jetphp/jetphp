<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class FormSistemaHome extends Formulario {
    public static $nome = 'Painel';
    public static $acao = 'Bem vindo!';
    public static $acaoformulario = 'U';

    public static function definirCampos() {
      self::$where = "id = 0".Admin::mostrar('id');
      self::$tabela = 'administrador_usuarios';

      echo '
        <p>Seja bem vindo ao gerenciador, guie-se pelo menu para adicionar conteúdo ao site!</p>
      ';

      self::adicionarCampo('password',['senha','Trocar senha'],'col-lg-12');
      self::mostrarCampos('alterar');
    }
  }
?>
