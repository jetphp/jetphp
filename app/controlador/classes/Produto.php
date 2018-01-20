<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */

  class Produto {
    public static function todos() {
        $sql = "SELECT
          produto.*,
          imagem.id as id_imagem,
          imagem.imagem as nome_imagem,
          categoria.nome as categoria
        FROM site_produto produto
          INNER JOIN site_produto_imagem imagem ON imagem.id_produto = produto.id
          INNER JOIN site_produto_categoria categoria ON categoria.id = produto.id_categoria
        ORDER BY imagem.ordem ASC";
        $qr  = DB::executar($sql);
        if ($qr->rowCount() > 0) {
          $arr_produtos = [];
          while ($row = $qr->fetch(PDO::FETCH_ASSOC)) {
            $arr_produtos[$row['categoria']]['categoria'] = $row['categoria'];
            $arr_produtos[$row['categoria']]['id_categoria'] = $row['id_categoria'];
            $arr_produtos[$row['categoria']]['produtos'][$row['id']]['id'] = $row['id'];
            $arr_produtos[$row['categoria']]['produtos'][$row['id']]['titulo'] = $row['titulo'];
          }
          return $arr_produtos;
        }
    }

    public static function categoriasPopulares() {
      $sql = "SELECT DISTINCT log.id_categoria,COUNT(0) as visitas,categoria.* FROM site_produto_categoria as categoria
INNER JOIN site_produto_categoria_log as log on log.id_categoria = categoria.id
GROUP BY log.id_categoria
ORDER BY visitas DESC
LIMIT 0,3";
      $qr  = DB::executar($sql);
      if ($qr->rowCount() > 0) {
        $cat = [];
        while ($r = $qr->fetch(PDO::FETCH_OBJ)) {
          $cat[$r->id_categoria] = $r->nome;
        }
      }
      return $cat;
    }

    public static function banner() {
      $sql = "SELECT
        produto.*,
        imagem.id as id_imagem,
        imagem.imagem as nome_imagem,
        categoria.nome as categoria
      FROM site_produto produto
        INNER JOIN site_produto_imagem imagem ON imagem.id_produto = produto.id
        INNER JOIN site_produto_categoria categoria ON categoria.id = produto.id_categoria
      WHERE produto.banner = 1 and imagem.ordem = 1
      ORDER BY imagem.ordem ASC";
      $qr = DB::executar($sql);

      if ($qr->rowCount() > 0) {
        return $qr->fetchAll(PDO::FETCH_OBJ);
      } else {
        return false;
      }
    }
    public static function dados($id=null,$idc=null) {
      $where = '1=1';
      if ($id != null) {
        $where .= ' and produto.id = 0'.$id;
      }
      if ($idc != null) {
        $where .= ' and categoria.id = 0'.$idc;
      }
        $sql = "SELECT
          produto.*,
          imagem.id as id_imagem,
          imagem.imagem as nome_imagem,
          categoria.nome as categoria
        FROM site_produto produto
          INNER JOIN site_produto_imagem imagem ON imagem.id_produto = produto.id
          INNER JOIN site_produto_categoria categoria ON categoria.id = produto.id_categoria
        WHERE $where
        ORDER BY imagem.ordem ASC";
      $qr = DB::executar($sql);
      // mostrar($sql);
      if ($qr->rowCount() > 0) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $ua = $_SERVER['HTTP_USER_AGENT'];
        if ($id != null) {
          DB::executar("INSERT INTO site_produto_log (id_produto,ip,ua) VALUES ($id,'$ip','$ua')");
        }
        if ($idc != null) {
          DB::executar("INSERT INTO site_produto_categoria_log (id_categoria,ip,ua) VALUES ($idc,'$ip','$ua')");
        }
        $o_produto = [];
        $o_produto['imagens'] = [];
        while ($row = $qr->fetch(PDO::FETCH_OBJ)) {
          if ($idc != null) {
            $o_produto[$row->id]['titulo'] = $row->titulo;
            $o_produto[$row->id]['descricao'] = $row->descricao;
            $o_produto[$row->id]['descricao_curta'] = $row->descricao_curta;
            $o_produto[$row->id]['categoria'] = $row->categoria;
            $o_produto[$row->id]['id_categoria'] = $row->id_categoria;

            $o_produto['id_categoria'] = $row->id_categoria;
            $o_produto['categoria'] = $row->categoria;
            if (file_exists('upload/site_produto_imagem/'.$row->nome_imagem)) {
              $o_produto[$row->id]['imagens'][$row->id_imagem] = Config::mostrar('PASTA_PADRAO').'upload/site_produto_imagem/'.$row->nome_imagem;
            }
          } else {
            $o_produto['titulo'] = $row->titulo;
            $o_produto['descricao'] = $row->descricao;
            $o_produto['descricao_curta'] = $row->descricao_curta;

            $o_produto['id_categoria'] = $row->id_categoria;
            $o_produto['categoria'] = $row->categoria;
            if (file_exists('upload/site_produto_imagem/'.$row->nome_imagem)) {
              $o_produto['imagens'][$row->id_imagem] = Config::mostrar('PASTA_PADRAO').'upload/site_produto_imagem/'.$row->nome_imagem;
            }
          }
        }
        return $o_produto;
      } else {
        return false;
      }
    }
  }
?>
