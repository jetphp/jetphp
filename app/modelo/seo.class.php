<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de SEO

  abstract class SEO {
    public static $seo = [];
    public static function adicionar($nome,$conteudo) {
      self::$seo[$nome] = $conteudo;
    }
    public static function mostrar($nome) {
      if (isset(self::$seo[$nome])) {
        return self::$seo[$nome];
      } else {
        return false;
      }
    }
  }
?>
