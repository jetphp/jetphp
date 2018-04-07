<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de envio de emails

  abstract class Criptography {
    public static function md5($texto) {
      return md5(Config::show('md5_salt').'_'.$texto);
    }
  }
?>
