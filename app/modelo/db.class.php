<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de bancos de dados

  abstract class DB {
    private static $conexao = null;
    private static function conectar() {
      self::$conexao = new PDO('mysql:host='.Config::mostrar('DB_HOST').';charset=utf8;dbname='.Config::mostrar('DB_NOME'),Config::mostrar('DB_USUARIO'),Config::mostrar('DB_SENHA'));
    }

    public static function executar($sql) {
      if (self::$conexao == null) {
        self::conectar();
      }
      $qr = self::$conexao->prepare($sql);
      $qr->execute();
      return $qr;
    }
  }
?>
