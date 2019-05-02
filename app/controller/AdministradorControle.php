<?php
  use JetPHP\Model\Load;
  use JetPHP\Model\Start;
  use JetPHP\Model\Config;
  use JetPHP\Classes\Admin;

  class AdministradorControle extends Controle {
    public function __construct() {
      Load::class('Admin');
    }

    public static function pagina($pagina=null) {
      if (\JetPHP\Classes\Admin::logado()) {
        if ($pagina == null) {
          $pagina = Start::get('pagina');
        }
         Admin::secao($pagina);
      } else {
        header('Location:'.Config::show('PASTA_PADRAO').Config::show('PASTA_ADMIN'));
      }
    }

    public static function index() {
      if (Admin::logado()) {
        self::pagina('home');
      } else {
        if (isset($_POST['usuario'])) {
          $arr_logar = Admin::logar();
        } else {
          $arr_logar = [];
        }
        return self::view('admin.login',$arr_logar,true,false);
      }
    }
  }
?>
