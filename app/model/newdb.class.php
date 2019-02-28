<?php // not stable
  class NewDB {
    public static function getInstance() {
      return new self;
    } 
    
    public function __construct() {
      $user = Config::show('DB_USUARIO');
      $pass = Config::show('DB_USUARIO');
      $db   = Config::show('DB_USUARIO');
      $host = Config::show('DB_USUARIO');
      try {
        $con = new \PDO("mysql:host={$host};charset=utf8;dbname={$db}", $user, $pass);
      } catch (\PDOException $e) {
      
      }
    }
  }
?>
