<?php // not stable
  class NewDB {
    private $con = null;
    private $stmt;
    private $query;
    
    private function connect() {
      $user = Config::show('DB_USUARIO');
      $pass = Config::show('DB_USUARIO');
      $db   = Config::show('DB_USUARIO');
      $host = Config::show('DB_USUARIO');
      try {
        $this->con = new \PDO("mysql:host={$host};charset=utf8;dbname={$db}", $user, $pass);
        return true;
      } catch (\PDOException $e) {
        return false;
      }
    }

    public static function getInstance() {
      return new self;
    }

    // 
    //  Normal query
    // 

    public function query($qr) {
      if ($this->con == null) {
        $c = $this->connect();
        if ($c) {
          echo "Erro ao conectar no db";
          die;
        }
      }

      $this->query = $qr;
      $this->stmt = $this->con->prepare($qr);
      return $this;
    }

    public function bind(array $params) {
      foreach ($params as $key => $value) {
        $key++;
        $this->stmt->bindParams($key,$value);
      }
      return $this;
    }


    // 
    // Auto functions
    // 

    

  }
?>
