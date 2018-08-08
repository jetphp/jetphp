<?php
  namespace JetPHP\Model;
  class Format {
    public static function mysqlData($data) {
      return date('d/m/Y',strtotime($data));
    }
    public static function urlTexto($texto) {
      return strtolower(str_replace(' ','-',$texto));
    }
    public static function dataMysql($data) {
      return date('Y-m-d',strtotime($data));
    }
    public static function convertPoints($val) {
      return str_replace('.','/',$val);
    }
    public static function dinheiro($dinheiro) {
      return \JetPHP\Model\Config::show('moeda').' '.number_format($dinheiro,2,',','.');
    }
    public static function limitar($texto,$limite) {
      $l = str_split($texto);
      $msg = '';
      for ($i=0; $i < $limite; $i++) { 
        if (isset($l[$i])) {
          $msg.= $l[$i];
        }
      }
      if (count($l) >= $limite) {
        $msg.= "...";
      }
      return $msg;
    }
  }
?>
