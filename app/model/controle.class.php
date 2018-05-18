<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Modelo do controle

  class Controle {
    public function view($caminho,$var=null,$admin=false,$menu=true) {
      if (file_exists('../vendor/autoload.php')) {
        Load::view($caminho,$var,$admin,$menu);
      } else {
        header('Location:'.Config::show('PASTA_PADRAO').'instalacao');
      }
    }
  }
?>
