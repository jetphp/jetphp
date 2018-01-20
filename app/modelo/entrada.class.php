<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de Entrada

  abstract class Entrada {
    public static function get($texto) {
      if (isset($_GET[$texto])) {
        return Seguranca::antisql($_GET[$texto]);
      }
    }
    public static function session($texto) {
      if (isset($_SESSION[$texto])) {
        return Seguranca::antisql($_SESSION[$texto]);
      }
    }
    public static function post($texto) {
      if (isset($_POST[$texto])) {
        return Seguranca::antisql($_POST[$texto]);
      }
    }
  }
?>
