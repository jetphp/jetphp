<?php
  namespace JetPHP\Model;
  class Formulario {
    public static $tabela;
    public static $acao = 'listar';
    public static $acaoformulario = '';
    public static $where = '1=1';
    public static $pasta = 'upload/';
    private static $campos = [];

    public function __construct() {
      if (Admin::$controle::$acaoformulario != '') {
        self::$acaoformulario = Admin::$controle::$acaoformulario;
      } else {
        if (Admin::mostrar('nivel') == '1') {
          self::$acaoformulario = 'UID';
        } else if (Admin::mostrar('nivel') == '2') {
          self::$acaoformulario = 'UID';
        } else {
          self::$acaoformulario = 'UI';
        }
      }
      self::$acao   = (isset($_GET['acao'])) ? Start::get('acao') : 'listar';
      include '../app/view/admin/inc/topo.phtml';
      include '../app/view/admin/inc/menu.phtml';
      include '../app/view/admin/inc/_base.phtml';
      Admin::$controle::definirCampos();
      include '../app/view/admin/inc/rodape1.phtml';
    }

    public static function adicionarCampo($tipo,$arr_nome,$divClass=null,$acao='LUI') {

      if (self::$acao == 'inserir' and strstr($acao,'I')) {
        if ($divClass != null) {
          $divClass = "$divClass";
        } else {
          $divClass = '';
        }
        $msg = '';
        switch ($tipo) {
          case 'textarea':
            $msg .= "<div class='input-group $divClass'>";
            $msg .= "<label for='{$tipo}_{$arr_nome[0]}'>{$arr_nome[1]}</label>";
            $msg .= "<textarea id='{$tipo}_{$arr_nome[0]}' name='{$arr_nome[0]}' placeholder='{$arr_nome[1]}' class='form-control'></textarea>";
            $msg .= "</div>";
          break;

          case 'boleano':
            $msg .= "<div class='input-group $divClass'>";
            $msg .= "<label>{$arr_nome[1]}</label><br>";
            $msg .= "<input type='radio' id='{$tipo}_{$arr_nome[0]}' name='{$arr_nome[0]}' value='1'> Sim<br>";
            $msg .= "<input type='radio' id='{$tipo}_{$arr_nome[0]}' name='{$arr_nome[0]}' value='0'> Não<br>";
            $msg .= "</div>";
          break;

          case 'select':
            $msg .= "<div class='input-group $divClass'>";
            $msg .= "<label for='{$tipo}_{$arr_nome[0]}'>{$arr_nome[1]}</label>";
            if (isset($arr_nome[2])) {
              $sql = "SELECT * FROM {$arr_nome[2]}";
              $qr  = \JetPHP\Model\DB::execute($sql);
              $msg .= "<select name='{$arr_nome[0]}' class='form-control'>";
              $msg .= "<option value='0'>--------</option>";
              if ($qr->generico()->rowCount() > 0) {
                while ($r = $qr->generico()->fetch(PDO::FETCH_ASSOC)) {
                  if (isset($_GET['id'])) {
                    if ($_GET['id'] == $r['id']) {
                      $sel = 'selected';
                    } else {
                      $sel = '';
                    }
                  } else {
                    $sel = '';
                  }
                  $msg .= "<option value='{$r['id']}' $sel>";
                  ?>
                    <?php
                      if (isset($r['nome'])) {
                        $msg .= $r['nome'];
                      } else if (isset($r['titulo'])) {
                        $msg .= $r['titulo'];
                      }
                    ?>
                  <?php
                  $msg .= '</option>';
                }
              } else {
                $msg .= "<option value='0'>Nenhum registro encontrado</option>";
              }
              $msg .= "</select>";
            }
            $msg .= "</div>";
          break;

          default:
            $msg .= "<div class='input-group $divClass'>";
            $msg .= "<label for='{$tipo}_{$arr_nome[0]}'>{$arr_nome[1]}</label>";
            $msg .= "<input type='{$tipo}' name='{$arr_nome[0]}' placeholder='{$arr_nome[1]}' class='form-control'>";
            $msg .= "</div>";
          break;
        }
        self::$campos[$arr_nome[0]] = $msg;
      } else if ((self::$acao == 'alterar' and strstr($acao,'U')) or (self::$acao == 'listar' and strstr($acao,'L'))) {
        self::$campos[$arr_nome[0]] = [
          'campo'=>$arr_nome[0],
          'nome'=>$arr_nome[1],
          'tabela'=>(isset($arr_nome[2])) ? $arr_nome[2] : '',
          'tipo'=>$tipo,
          'divClass'=>$divClass,
          'acao'=>$acao
        ];
      }

    }

    public static function listagem($id=null) {
      if ($id != null) {
        $where = 'WHERE id=0'.$id;
      } else {
        $where = '';
      }
      if ($where == '') {
        $where.= 'WHERE '.self::$where;
      } else {
        $where.= ' AND '.self::$where;
      }
      $chaves = array_keys(self::$campos);
      $campos = implode(',',$chaves);

      $sql = "SELECT {$campos} FROM ".self::$tabela." {$where}";
      $qr  = \JetPHP\Model\DB::execute($sql);
      if ($qr->generico()->rowCount() > 0) {
        if ($id != null) {
          return $qr->generico()->fetch(PDO::FETCH_ASSOC);
        } else {
          return $qr->generico()->fetchAll(PDO::FETCH_ASSOC);
        }
      } else {
        return false;
      }
    }

    public static function mostrarCampos($acao=null) {
      if ($acao == null) {
        $acao = self::$acao;
      }

      if (isset($_POST) and count($_POST) > 0) {
        $set = [];
        foreach ($_POST as $key => $value) {
          if ($key != 'enviar' and $key != 'imagem') {
            if ($key == 'senha') {
              $value = Criptography::md5($value);
            }
            $set[] = "$key = '$value'";
          }
        }

        if (isset($_GET['id']) or strstr(self::$where,'id') or $acao == 'inserir' or $acao == 'remover') {
          if (strstr(self::$where,'id')) {
            $where = self::$where;
          } else {
            $where = 'id = '.Start::get('id');
          }
          switch ($acao) {
            case 'alterar':
              $sql = "UPDATE ".self::$tabela." SET ".implode(',',$set)." WHERE $where";
              $qr  = \JetPHP\Model\DB::execute($sql);
              $id = Start::get('id');
              // mostrar($sql);
              if ($qr->generico()->rowCount() > 0 or isset($_FILES['imagem'])) {
                if (isset($_FILES['imagem'])) {
                  if (isset($_FILES['imagem']['name']) and $_FILES['imagem']['name'] != '') {
                    $imagem = $_FILES['imagem'];
                    $ext = strchr($imagem['name'],'.');
                    $tipo = $imagem['type'];

                    $tipos = [
                      'image/asdf',
                      'image/jpeg',
                      'image/jpg',
                      'image/png'
                    ];
                    $exts = [
                      '.asdf',
                      '.jpg',
                      '.png'
                    ];
                    if (array_search($ext,$exts) and array_search($tipo,$tipos)) {
                      $pasta = (isset(Admin::$controle::$pasta)) ? Admin::$controle::$pasta : self::$pasta;
                      if (!file_exists($pasta.self::$tabela)) {
                        mkdir($pasta.self::$tabela);
                      }

                      $nomeimg = Criptography::md5($imagem['name'].time()).$ext;
                      if (move_uploaded_file($imagem['tmp_name'],$pasta.self::$tabela.'/'.$nomeimg)) {
                        \JetPHP\Model\DB::execute("UPDATE ".self::$tabela." SET imagem='".$nomeimg."' WHERE id=0".$id);
                        echo "<p class='text-success'>Alterado com sucesso</p>";
                      } else {
                        echo "<p class='text-danger'>Erro ao alterar</p>";
                      }
                    } else {
                      echo "<p class='text-danger'>Erro ao alterar</p>";
                    }
                  } else {
                    echo "<p class='text-success'>Alterado com sucesso</p>";
                  }
                } else {
                  echo "<p class='text-success'>Alterado com sucesso</p>";
                }
              } else {
                echo "<p class='text-danger'>Erro ao alterar</p>";
              }
            break;
            case 'inserir':
              $p    = [];
              $post = [];
              foreach ($_POST as $key => $value) {
                if ($key != 'imagem') {
                  if ($key == 'senha') {
                    $post[] = "'".Criptography::md5($value)."'";
                  } else {
                    $post[] = "'$value'";
                  }
                }
              }
              foreach (array_keys($_POST) as $key => $value) {
                if ($value != 'imagem') {
                  $p[] = $value;
                }
              }
              $sql = "INSERT INTO ".self::$tabela." (".implode(',',$p).") VALUES (".implode(',',$post).")";
              // mostrar($sql);
              $qr  = \JetPHP\Model\DB::execute($sql);
              if ($qr->generico()->rowCount() > 0) {
                if (isset($_FILES['imagem'])) {
                  if (isset($_FILES['imagem']['name']) and $_FILES['imagem']['name'] != '') {
                    $l = \JetPHP\Model\DB::execute("SELECT * FROM ".self::$tabela." WHERE (imagem IS NULL or imagem = '') ORDER BY id DESC");
                    $r = $l->generico()->fetch(PDO::FETCH_OBJ);
                    $id = $r->id;
                    $imagem = $_FILES['imagem'];
                    $ext = strchr($imagem['name'],'.');
                    $tipo = $imagem['type'];

                    $tipos = [
                      'image/asd',
                      'image/jpeg',
                      'image/jpg',
                      'image/png'
                    ];
                    $exts = [
                      '.asd',
                      '.jpg',
                      '.jpg',
                      '.png'
                    ];
                    if (array_search($ext,$exts) and array_search($tipo,$tipos)) {
                      $pasta = (isset(Admin::$controle::$pasta)) ? Admin::$controle::$pasta : self::$pasta;
                      if (!file_exists($pasta.self::$tabela)) {
                        mkdir($pasta.self::$tabela);
                      }
                      $nomeimg = Criptography::md5($imagem['name'].time()).$ext;
                      if (move_uploaded_file($imagem['tmp_name'],$pasta.self::$tabela.'/'.$nomeimg)) {
                        \JetPHP\Model\DB::execute("UPDATE ".self::$tabela." SET imagem='".$nomeimg."' WHERE id=0".$id);
                        echo "<p class='text-success'>Inserido com sucesso</p>";
                      } else {
                        \JetPHP\Model\DB::execute("DELETE FROM ".self::$tabela." WHERE id=0".$id);
                        echo "<p class='text-danger'>Erro ao inserir</p>";
                      }
                    } else {
                      echo "$ext - $tipo";
                      \JetPHP\Model\DB::execute("DELETE FROM ".self::$tabela." WHERE id=0".$id);
                      echo "<p class='text-danger'>Erro ao inserir</p>";
                    }
                  } else {
                    echo "<p class='text-success'>Inserido com sucesso</p>";
                  }
                } else {
                  echo "<p class='text-success'>Inserido com sucesso</p>";
                }
              } else {
                echo "<p class='text-danger'>Erro ao inserir</p>";
              }
            break;

            default:
            echo "<p>Você não pode fazer requisições POST nessa página.</p>";
            break;
          }
        }
      }


      if ($acao == 'inserir') {
        ?>
        <div class="container-fluid">
          <form method="post" enctype="multipart/form-data">
            <?php
            foreach (self::$campos as $nome => $campo) {
              echo "$campo\n";
            }
            ?>
            <input type="submit" value="Inserir" class="btn btn-warning pull-right">
          </form>
        </div>
        <?php
      } else if ($acao == 'alterar') {
        if (isset($_GET['id']) or strstr(self::$where,'id')) {
          $id = Start::get('id');
          $dados = self::listagem($id);
          ?>
          <div class="container-fluid">
            <form action="" method="post" enctype="multipart/form-data">
            <?php
              foreach (self::$campos as $nome => $campo) {
            ?>
              <?php
              if (strstr($campo['acao'],'U')) {
                switch ($campo['tipo']) {
                  case 'textarea':
                  ?>
                  <div class="input-group <?php echo $campo['divClass']; ?>">
                    <label for="<?php echo $campo['tipo'] ?>_<?php echo $campo['campo'] ?>"><?php echo $campo['nome'] ?></label>
                    <textarea name="<?php echo $campo['campo'] ?>" id="<?php echo $campo['tipo'] ?>_<?php echo $campo['campo'] ?>" rows="5" class="form-control"><?php echo $dados[$nome] ?></textarea>
                  </div>
                  <?php
                  break;

                  case 'boleano':
                  $msg  = '';
                  $msg .= "<div class='input-group {$campo['divClass']}'>";
                  $msg .= "<label>{$campo['nome']}</label><br>";
                  $msg .= "<input type='radio' id='{$campo['tipo']}_{$campo['campo']}' name='{$campo['campo']}' value='1' ".($dados[$nome] == 1 ? 'checked' : '')."> Sim<br>";
                  $msg .= "<input type='radio' id='{$campo['tipo']}_{$campo['campo']}' name='{$campo['campo']}' value='0' ".($dados[$nome] == 0 ? 'checked' : '')."> Não<br>";
                  $msg .= "</div>";
                  echo $msg;
                  break;

                  case 'select':
                    echo "<div class='input-group {$campo['divClass']}'>";
                    echo "<label for='{$campo['tipo']}_{$campo['campo']}'>{$campo['nome']}</label>";

                    if (isset($campo['tabela'])) {
                      $sql = "SELECT * FROM {$campo['tabela']}";
                      $qr  = \JetPHP\Model\DB::execute($sql);
                      echo "<select name='{$campo['campo']}' class='form-control'>";
                      if ($qr->generico()->rowCount() > 0) {
                        echo "<option value='0'>--------</option>";
                        while ($r = $qr->generico()->fetch(PDO::FETCH_ASSOC)) {
                          if (isset($_GET['id'])) {
                              if ($dados[$nome] == $r['id']) {
                              $sel = 'selected';
                            } else {
                              $sel = '';
                            }
                          } else {
                            $sel = '';
                          }
                          echo "<option value='{$r['id']}' $sel>";
                          ?>
                            <?php
                              if (isset($r['nome'])) {
                                echo $r['nome'];
                              } else if (isset($r['titulo'])) {
                                echo $r['titulo'];
                              }
                            ?>
                          <?php
                          echo '</option>';
                        }
                      } else {
                        echo "<option value='0'>Nenhum registro encontrado</option>";
                      }
                      echo "</select>";
                    }
                    echo "</div>";
                  break;

                  default:
                  ?>
                  <div class="input-group <?php echo $campo['divClass']; ?>">
                    <label for="<?php echo $campo['tipo'] ?>_<?php echo $campo['campo'] ?>"><?php echo $campo['nome']; ?></label>
                    <input type="<?php echo $campo['tipo']; ?>" id="<?php echo $campo['tipo'] ?>_<?php echo $campo['campo'] ?>" value="<?php echo ($campo['tipo']!='password')?$dados[$nome]:''; ?>" name="<?php echo $campo['campo']; ?>" placeholder="<?php echo $campo['nome']; ?>" class="form-control">
                  </div>
                  <?php
                  break;
                }
              }
              ?>
            <?php
          }
          ?>
            <input type="submit" value="Alterar" class="btn btn-warning pull-right">
            </form>
          </div>
          <?php
        } else {
          echo "<script>location.replace('?acao=listar');</script>";
        }
      } else if ($acao == 'listar') {
        $dados = self::listagem();
        if (!is_array($dados)) {
          echo "Nenhum registro encontrado";
        } else {
        ?>
          <table class="table table-striped">
            <tr>
              <?php
                foreach (self::$campos as $nome => $campo) {
                  ?>
                    <th><?php echo strtoupper($campo['nome']); ?></th>
                  <?php
                }
                ?>
                <th colspan="2">Ação</th>
                <?php
              ?>
            </tr>
            <?php
              foreach ($dados as $campo => $valor) {
                ?><tr><?php
                foreach (self::$campos as $chave => $cv) {
                  if ($cv['tipo'] == 'img') {
                    $valor[$chave] = "<img class='img-responsive tr-img' src='".Config::show('PASTA_PADRAO')."upload/".self::$tabela."/".$valor[$chave]."'>";
                  }
                  ?>
                    <td><?php echo $valor[$chave]; ?></td>
                  <?php
                }
                ?>
                  <td>
                    <?php
                      if (strstr(self::$acaoformulario,'U')) {
                        ?>
                        <a href="?acao=alterar&id=<?php echo $valor['id']; ?>" class="btn btn-success btn-circle"> <i class="fa fa-pencil"></i> </a>
                        <?php
                      }
                    ?>
                    <?php
                      if (strstr(self::$acaoformulario,'D')) {
                        ?>
                        <a href="?acao=remover&id=<?php echo $valor['id']; ?>" class="btn btn-danger btn-circle"> <i class="fa fa-times"></i> </a>
                        <?php
                      }
                    ?>
                  </td>
                <?php
                ?></tr><?php
              }
            ?>
          </table>
        <?php
        }
      } else if ($acao == 'remover' and isset($_GET['id'])) {
        $id = Start::get('id');
        $sql = "DELETE FROM ".self::$tabela. " WHERE id=0".$id;
        if (DB::execute($sql)->generico()->rowCount() > 0) {
          echo "<p class='text-success'>Deletado com sucesso.</p>";
        } else {
          echo "<p class='text-danger'>Erro ao remover</p>";
        }
        echo "<script>setTimeout(function(){history.back();},1500);</script>";
      } else {
        echo "<p>Ação não encontrada.</p>";
      }
    }
  }
?>
