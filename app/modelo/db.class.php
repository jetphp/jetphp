<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de bancos de dados

  class DB {
    private static $conexao = null;
    private static $qr      = null;

    private static function conectar() {
      if (self::$conexao != null) {
        return true;
      } else {
        try {
          self::$conexao = new PDO('mysql:host='.Config::show('DB_HOST').';charset=utf8;dbname='.Config::show('DB_NOME'),Config::show('DB_USUARIO'),Config::show('DB_SENHA'));
          return true;
        } catch (PDOException $e) {
          echo "<p>Erro ao conectar no banco de dados: <b>".$e->getMessage()."</b></p>";
          return false;
        }
      }
    }

    public static function contar() {
      return self::$qr->rowCount();
    }
    
    public static function listar($tipo) {
      return self::$qr->fetch($tipo);
    }

    public static function generico() {
      return self::$qr;
    }


    public static function executar($sql) {
      if (self::conectar()) {
        $qr = self::$conexao->prepare($sql);
        $qr->execute();
        self::$qr = $qr;
        return new self;
      }
    }
  }
?>
