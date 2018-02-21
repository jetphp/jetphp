<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo de Texto

  abstract class Texto {
    public static function mostrar($nome) {
      $sql = "SELECT * FROM site_texto WHERE identificador='$nome'";
      $qr = DB::executar($sql);
      if ($qr->generico()->rowCount() > 0) {
        $row = $qr->generico()->fetch(PDO::FETCH_OBJ);
        return $row->conteudo;
      }
    }
  }
?>
