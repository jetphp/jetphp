<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de SEO

  abstract class SEO {
    public static $seo = [];
    public static function add($nome,$conteudo) {
      self::$seo[$nome] = $conteudo;
    }
    public static function show($nome) {
      if (isset(self::$seo[$nome])) {
        return self::$seo[$nome];
      } else {
        return false;
      }
    }
    public static function ready() {
      if (count(self::$seo) > 0) {
        foreach (self::$seo as $nome => $valor) {
          switch ($nome) {
            case 'descricao':
              echo "<meta name='description' content='$valor'>\n";
              break;
            case 'titulo':
              echo "<meta name='title' content='$valor'>\n";
              break;

            default:
              echo "<meta name='$nome' content='$valor'>\n";
              break;
          }
        }
      }
    }
  }
?>
