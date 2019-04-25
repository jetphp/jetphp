<?php
namespace JetPHP\Model;
class Route {
  public static $rota = [];
  public static function add($caminho,$acao) {
    self::$rota[$caminho] = $acao;
  }

  public static function load($caminho) {
    if (Config::show('PASTA_PADRAO') == '/') {
      $caminho = explode('/',$caminho);
      $c       = '';
      foreach ($caminho as $chave=>$valor) {
        end($caminho);
        if ($valor != '') {
          if ($chave != key($caminho)) {
            $c.= $valor.'/';
          } else {
            $c.= $valor;
          }
        } else {
          unset($caminho[$chave]);
        }
      }
      if (count($caminho) >= 2) {
        $var = explode('/',$c);
        $cam = '';
        $temvar = false;
        $rotaatual = '';
        if (!$temvar) {
          foreach ($var as $key => $value) {
            $cam.=$value;
            if ($key != count($var)-1) {
              $cam.='/';
            }
            $args = $caminho;
            unset($args[2]);
            if (self::check($cam,true, $args)) {
              $temvar = true;
              $rotaatual = $cam;
            } else {
              $temvar = false;
            }
          }
        }
      }

      $caminho = $c;
    } else {
      $caminho = str_replace(Config::show('PASTA_PADRAO'),'',$caminho);
    }
    if (isset($rotaatual)) {} else {
      $rota = self::check($caminho);
      if (is_string($rota)) {
        $rota = explode('@',$rota);
        $func = $rota[0];
        $cont = $rota[1];

        if (file_exists('../app/controller/'.$cont.'.php')) {
          include '../app/controller/'.$cont.'.php';
          $cont = new $cont();
          $cont::$func();
        } else {
          \JetPHP\Model\Load::view('erro.404');
        }
      } else if (is_callable($rota)) {
        return $rota();
      } else {
        \JetPHP\Model\Load::view('erro.404');
      }
    }
  }

  private static function check($caminho,$pesquisa=false,$args=[]) {
    if ($pesquisa) {
      $chaves = array_keys(self::$rota);
      $ch = [];
      foreach ($chaves as $chave) {
        if (strstr($chave , ':')) {
          $exp = explode('/',$chave);
          $princ = $exp[0];
          unset($exp[0]);
          $ch[$princ.'/'][] = $exp;
        } else {
          if ($chave != '')
            $ch[$chave] = null;
        }
      }

      if (isset($ch[$caminho])) {
        $arrRota = $ch[$caminho];

        if (count($arrRota) > 1) {
          if (count($args) > 0) {
            $infoRotas = [];
            $arrArgs = [];
            $arrGet = [];
            foreach ($arrRota as $item) {
              $infoRotas[] = count($item);
            }
            foreach ($args as $item) {
              $arrArgs[] = $item;
            }

            $index = array_search(count($args), $infoRotas);
            $rotaCerta = [];
            foreach ($arrRota[$index] as $item) {
              $rotaCerta[] = str_replace(':','',$item);
            }

            foreach ($rotaCerta as $i=>$chave) {
              $arrGet[$chave] = $arrArgs[$i];
              $_GET[$chave] = $arrArgs[$i];
            }
          }

        } else {
          $arrArgs = [];
          $arrGet = [];
          foreach ($arrRota as $item) {
            $infoRotas[] = count($item);
          }
          foreach ($args as $item) {
            $arrArgs[] = $item;
          }

          $index = 0;
          $rotaCerta = [];
          foreach ($arrRota[$index] as $item) {
            $rotaCerta[] = str_replace(':','',$item);
          }

          foreach ($rotaCerta as $i=>$chave) {
            $arrGet[$chave] = $arrArgs[$i];
            $_GET[$chave] = $arrArgs[$i];
          }
        }
      }

      $arr_chaves = [];
      $arr_chave  = [];
      $arr_vars   = [];
      foreach ($chaves as $n=>$chave) {
        $arr_chave[$n] = $chave;
        $a = explode(':',$chave);
        $arr_chaves[$n] = $a[0];
        unset($a[0]);
        $arr_vars[$n][] = $a;
      }

      $pesquisar  = array_search($caminho,$arr_chaves);
      if ($pesquisar) {
        if (isset($arr_vars[$pesquisar][0]) and count($arr_vars[$pesquisar][0]) > 0) {

          if (isset($erro) and $erro) {
            \JetPHP\Model\Load::view('erro.404');
          } else {
            $rota = self::$rota[$arr_chave[$pesquisar]];
            $rota = explode('@',$rota);
            $func = $rota[0];
            $cont = $rota[1];

            if (file_exists('../app/controller/'.$cont.'.php')) {
              $_SESSION['caminho'] = $caminho;
              include '../app/controller/'.$cont.'.php';
              $cont = new $cont();
              $cont::$func();
            } else {
              \JetPHP\Model\Load::view('erro.404');
            }
          }
        } else {
          \JetPHP\Model\Load::view('erro.404');
        }
      } else {
        if (!isset($_SESSION['caminho'])) {
          \JetPHP\Model\Load::view('erro.404');
        }

      }
    } else {
      if (isset(self::$rota[$caminho]) or isset(self::$rota[$caminho.'/'])) {
        return (isset(self::$rota[$caminho])) ? self::$rota[$caminho] : self::$rota[$caminho.'/'];
      } else {
        return false;
      }
    }
  }

  public static function show() {
    return self::$rota;
  }
}
?>
