<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class FormSistemaSair {
    public function __construct() {
      unset($_SESSION['dados']);
      header("Location:".Config::show('PASTA_PADRAO').Config::show('PASTA_ADMIN'));
    }
  }
?>
