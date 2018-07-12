<?php
  namespace JetPHP\Classes;
  class Admin {
    public static $controle = '';

    public static function logado() {
      if (isset($_SESSION['dados'])) {
        return true;
      } else {
        return false;
      }
    }

    public static function mostrar($campo) {
      if (isset($_SESSION['dados'])) {
        $sql = "SELECT * FROM administrador_usuarios WHERE id=0".$_SESSION['dados'];
        $qr  = \JetPHP\Model\DB::execute($sql);
        if ($qr->generico()->rowCount() > 0) {
          $r = $qr->generico()->fetch(PDO::FETCH_OBJ);
          return $r->$campo;
        }
      } else {
        return false;
      }
    }

    public static function secao($pagina) {
      $sql = "SELECT * FROM administrador_secao WHERE pagina='$pagina' AND nivel >= 0".self::mostrar('nivel');
      $qr  = \JetPHP\Model\DB::execute($sql);
      if ($qr->generico()->rowCount() > 0) {
        $r = $qr->generico()->fetch(PDO::FETCH_OBJ);
        if (file_exists('../app/controller/admin/'.$r->controle.'.php')) {
          include '../app/controller/admin/'.$r->controle.'.php';
          
          self::$controle = $r->controle;
          new $r->controle;
        } else {
          \JetPHP\Model\Load::view('erro.404');
        }
      } else {
        \JetPHP\Model\Load::view('erro.404');
      }
    }

    public static function montarMenu() {
      if (self::logado()) {
        $dados = $_SESSION['dados'];
        $sql   = "SELECT * FROM administrador_secao WHERE nivel >= 0".self::mostrar('nivel')." ORDER BY ordem ASC";
        $qr    = \JetPHP\Model\DB::execute($sql);
        if ($qr->generico()->rowCount() > 0) {
          $menu = [];
          while ($row = $qr->generico()->fetch(PDO::FETCH_ASSOC)) {
            echo '
              <li>
                <a href="'.Config::show('PASTA_PADRAO').Config::show('PASTA_ADMIN').$row['pagina'].'">
                  <i class="fa '.$row['icone'].'"></i>
                  '.$row['nome'].'
                </a>
              </li>
            ';
          }
        }
      }
    }

    public static function logar() {
      $usuario = Start::post('usuario');
      $senha   = Criptography::md5(Start::post('senha'));

      $sql = "SELECT * FROM administrador_usuarios WHERE usuario='$usuario' and senha='$senha' and ativo=1";
      $qr  = \JetPHP\Model\DB::execute($sql);
      if ($qr->generico()->rowCount() > 0) {
        $r = $qr->generico()->fetch(PDO::FETCH_ASSOC);
        $_SESSION['dados'] = $r['id'];
        header('Location:'.Config::show('PASTA_PADRAO').Config::show('PASTA_ADMIN'));
        return ['status'=>true,'msg'=>'Logado com sucesso!'];
      } else {
        return ['status'=>false,'msg'=>'Usuário e/ou senha incorretos'];
      }
    }
  }
?>
