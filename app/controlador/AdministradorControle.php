<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class AdministradorControle extends Controle {
    public function __construct() {
      Carregar::classe('Admin');
    }

    public static function pagina($pagina=null) {
      if (Admin::logado()) {
        if ($pagina == null) {
          $pagina = Entrada::get('pagina');
        }
        Admin::secao($pagina);
      } else {
        header('Location:'.Config::mostrar('PASTA_PADRAO').Config::mostrar('PASTA_ADMIN'));
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
        Carregar::view('admin.login',$arr_logar,true,false);
      }
    }
  }
?>
