<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  // Carregar modelos
  session_start();

  foreach (glob('app/modelo/*.class.php') as $arquivo) {
    include $arquivo;
  }

  include 'app/configuracao.php';
  include 'app/rota.php';
  include 'app/principal/joaoartur.php';

  if (Config::mostrar('DEBUG')) {
    ini_set('display_errors',1);
  }


  new JoaoArtur;
?>
