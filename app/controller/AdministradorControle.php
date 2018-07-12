<?php
  class AdministradorControle extends Controle {
    public function __construct() {
      \JetPHP\Model\Load::class('Admin');
    }

    public static function pagina($pagina=null) {
      if (\JetPHP\Classes\Admin::logado()) {
        if ($pagina == null) {
          $pagina = Start::get('pagina');
        }
         \JetPHP\Classes\Admin::secao($pagina);
      } else {
        header('Location:'.\JetPHP\Model\Config::show('PASTA_PADRAO').\JetPHP\Model\Config::show('PASTA_ADMIN'));
      }
    }

    public static function index() {
      if ( \JetPHP\Classes\Admin::logado()) {
        self::pagina('home');
      } else {
        if (isset($_POST['usuario'])) {
          $arr_logar =  \JetPHP\Classes\Admin::logar();
        } else {
          $arr_logar = [];
        }
        return self::view('admin.login',$arr_logar,true,false);
      }
    }
  }
?>
