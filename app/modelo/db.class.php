<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de bancos de dados

  class DB {
    private static $conexao = null;
    private static $qr      = null;

    private static function connect() {
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

    public static function count() {
      return self::$qr->rowCount();
    }

    public static function list($tipo=PDO::FETCH_OBJ) {
      return self::$qr->fetch($tipo);
    }

    public static function generico() {
      return self::$qr;
    }


    public static function execute($sql, $bp='') {
      if (self::connect()) {
        $qr = self::$conexao->prepare($sql);
        if (is_array($bp)) {
          foreach ($bp as $name=>$param) {
            $qr->bindParam($name,$param);
          }
        }
        $qr->execute();
        self::$qr = $qr;
        return new self;
      }
    }
  }
?>
