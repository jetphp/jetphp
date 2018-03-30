<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de configurações

  abstract class Config {
    public static $config = [];

    public static function add($nome,$valor) {
      self::$config[$nome] = $valor;
    }

    public static function show($nome) {
      if (isset(self::$config[$nome])) {
        return self::$config[$nome];
      } else {
        return false;
      }
    }

    public static function url($pasta='') {
      return 'http://'.$_SERVER['HTTP_HOST'].Config::show('PASTA_PADRAO').$pasta;
    }
  }
?>
