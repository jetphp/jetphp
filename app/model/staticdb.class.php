<?php
  namespace JetPHP\Model;
  class StaticDB {
    public $where = '';
    public $join = '';
    public function __construct() {
      $qr_e = \JetPHP\Model\DB::execute("SHOW TABLES");
      if ($qr_e::count() > 0) {
        while ($tabela = $qr_e::list(PDO::FETCH_OBJ)) {
          foreach ($tabela as $nome) {
            $funcionalidades = $this;
            $this->$nome = function() use ($nome, &$funcionalidades) {
              $funcionalidades->atual = $nome;
              return $funcionalidades;
            };
          }
        }
      }
    }
    public function where($w) {
      $this->where = $w;
      return $this;
    }
    public function join($t) {
      $this->join = $t;
      return $this;
    }
    public function show($tipo=null,$tipo_pdo=PDO::FETCH_OBJ) {
      $sql = "SELECT * FROM {$this->atual} {$this->join} WHERE 1=1";
      if ($this->where != '' and $this->where != null) {
        $sql .= " AND {$this->where}";
      }
      if (is_numeric($tipo)) { // ID único
        $sql .= " and {$this->atual}.id=$tipo";
        $qr = \JetPHP\Model\DB::execute($sql)->generico()->fetch($tipo_pdo);
      } elseif ($tipo == 'all') { // Retornar todos os registros
        $qr = \JetPHP\Model\DB::execute($sql)->generico()->fetchAll($tipo_pdo);
      } elseif ($tipo == false) { // Retornar único registro
        $qr = \JetPHP\Model\DB::execute($sql)->generico()->fetch($tipo_pdo);
      } else {}
      $this->where = '';
      $this->join = '';
      return $qr;
    }
  }


  /*
    Como utilizar um banco de dados estaticamente?

    1º - Instancie a classe:
    $dbe = new DBE();
    2º - Chame sua tabela:
    $NomeTabela = $dbe->NomeTabela;
    3º - Utilize um dos 3 tipos de retorno:
    $NomeTabela()->mostrar(1); // Lista dados a partir do ID
    $NomeTabela()->mostrar(false); // Lista um único registro, de forma que fique mais prático executar usando while
    $NomeTabela()->mostrar(); // Lista todos os registros
  */
