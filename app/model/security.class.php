<?php
  namespace JetPHP\Model;
  class Security {
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
