<?php
  /*
  * @author João Artur - www.joaoartur.com - www.github.com/JoaoArtur
  */
  if (!file_exists('vendor/autoload.php')) {
    echo "<p>Leia a <a href='https://github.com/JoaoArtur/JetPHP'>documentação do JetPHP</a> para aprender a instalar as dependências do framework!</p>";
  } else {
    include 'vendor/autoload.php';
    include 'app/principal/iniciar.php';
  }
?>
