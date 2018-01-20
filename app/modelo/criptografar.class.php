<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de envio de emails

  abstract class Criptografar {
    public static function md5($texto) {
      return md5(Config::mostrar('md5_salt').'_'.$texto);
    }
  }
?>
