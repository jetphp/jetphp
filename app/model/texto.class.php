<?php
  namespace JetPHP\Model;
  abstract class Texto {
    public static function mostrar($nome) {
      $sql = "SELECT * FROM site_texto WHERE identificador='$nome'";
      $qr = \JetPHP\Model\DB::execute($sql);
      if ($qr->generico()->rowCount() > 0) {
        $row = $qr->generico()->fetch(PDO::FETCH_OBJ);
        return $row->conteudo;
      }
    }
  }
?>
ð