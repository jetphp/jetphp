<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class AdministradorControle extends Controle {
    public function __construct() {
      Load::class('Admin');
    }

    public static function pagina($pagina=null) {
      if (Admin::logado()) {
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
