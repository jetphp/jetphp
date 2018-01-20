<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class FormSistemaSair {
    public function __construct() {
      unset($_SESSION['dados']);
      header("Location:".Config::mostrar('PASTA_PADRAO').Config::mostrar('PASTA_ADMIN'));
    }
  }
?>
