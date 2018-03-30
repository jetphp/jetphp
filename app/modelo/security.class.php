<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de Segurança

  abstract class Security {
    public static function antisql($texto) {
      return htmlspecialchars(str_replace([
        "'",
        "\\",
        ";",
        "="
      ],'',$texto));
    }
  }
?>
