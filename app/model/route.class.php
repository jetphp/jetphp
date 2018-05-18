<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de rotas

  abstract class Route {
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
              if (self::check($cam,true)) {
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
            Load::view('erro.404');
          }
        } else if (is_callable($rota)) {
          return $rota();
        } else {
          Load::view('erro.404');
        }
      }
    }

    private static function check($caminho,$pesquisa=false) {
      if ($pesquisa) {
        $chaves = array_keys(self::$rota);
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
            $vars = $arr_vars[$pesquisar][0];
            $url  = explode('/',JoaoArtur::rotaAtual());
            foreach($url as $k=>$u): if ($u == ''): unset($url[$k]); endif;endforeach;
            foreach ($vars as $key => $value) {
              $k = $key+1;
              if (isset($url[$k])) {
                $acv = str_replace('/','',$value);
                if ($acv == 'id') {
                  $_GET[$acv] = intval($url[$k]);
                } else {
                  $_GET[$acv] = $url[$k];
                }
              } else {
                $erro = true;
              }
            }
            if (isset($erro) and $erro) {
              Load::view('erro.404');
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
                Load::view('erro.404');
              }
            }
          } else {
            Load::view('erro.404');
          }
        } else {
          if (!isset($_SESSION['caminho'])) {
            Load::view('erro.404');
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
