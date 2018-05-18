<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de bancos de dados

  abstract class Load {
    public static $css = [];
    public static $js  = [];

    public static function view($caminho,$var=null,$admin=false,$menu=true) {
      $caminho = str_replace('.','/',$caminho);
      unset($_SESSION['caminho']);
      if (!isset($_SESSION['caminho']) and file_exists('../app/view/'.$caminho.'.phtml')) {
        $_SESSION['caminho'] = $caminho;
        if ($var != null and is_array($var)) {
          extract($var);
        }

        if ($admin) {
          $adm = 'admin/';
        } else {
          $adm = '';
        }
        include '../app/view/'.$adm.'inc/topo.phtml';
        if ($menu) {
          include '../app/view/'.$adm.'inc/menu.phtml';
        }
        include '../app/view/'.$caminho.'.phtml';
        include '../app/view/'.$adm.'inc/rodape.phtml';
        return true;
      } else {
        return false;
      }
    }

    public static function class($classe) {
      $arq = "../app/controller/classes/$classe.php";
      if (file_exists($arq)) {
        include $arq;
      }
    }

    public static function css($arq,$admin=false) {
      if ($admin) {
        $misc = Config::show('ADMIN_MISC');
      } else {
        $misc = Config::show('PASTA_MISC');
      }
      self::$css[] = '<link rel="stylesheet" type="text/css" href="'.$misc.'css/'.$arq.'">';
    }

    public static function js($arq,$admin=false) {
      if ($admin) {
        $misc = Config::show('ADMIN_MISC');
      } else {
        $misc = Config::show('PASTA_MISC');
      }
      self::$js[] = '<script src="'.$misc.'js/'.$arq.'"></script>';
    }

    public static function mostrarJS() {
      foreach (self::$js as $key => $value) {
        echo $value;
      }
    }

    public static function mostrarCSS() {
      foreach (self::$css as $key => $value) {
        echo $value;
      }
    }
  }
?>
