<?php
    namespace JetPHP\Model;
    class JetForms {
        public $title, $action, $allowed_actions;
        private $table, $where, $limit, $query, $fields, $last_field, $records, $t_header, $t_body, $f_columns;

        public function __construct() {
            $this->query = false;
            $this->table = false;
            $this->where = false;
            $this->limit = false;

            $this->title  = null;
            $this->action = 'list';
            $this->allowed_actions = 'UID';

            $this->fields = [];
            $this->records = [];

            $this->t_header = '';
            $this->t_body = '';
        }

        public function initForm($table_name=false) {
            // Check if the form will init with a query or a table.
            $c = explode(' ',$table_name);

            if (count($c) > 1) {
                $this->query = $table_name;
                $this->table = false;
            } else {
                $this->table = $table_name;
                $this->query = false;
            }
            return $this;
        }

        public function loadForm() {
            $action = (Start::get('acao') == false) ? 'list' : Start::get('acao');

            switch ($action) {
                case 'list':
                    $this->listView();
                break;
                case 'edit':
                    $this->editView();
                break;

                case 'delete':
                    $this->deleteView();
                break;

                case 'add':
                    $this->addView();
                break;
            }

        }


        // ------ Fields section  ------

        public function addField($name,$allowed_actions='LUI') {
            $this->fields[$name] = [
                'field' => $name,
                'action' => $allowed_actions
            ];
            $this->last_field = $name;
            return $this;
        }

        public function addProperty($type,$value) {
            $this->fields[$this->last_field][$type] = $value;
            return $this;
        }

        public function addClass($class) {
            $this->fields[$this->last_field]['class'] = $class;
        }



        // ------- End fields section -------


        // ------- listView method -------
        private function listView() {

            if ($this->query != false) {
                $query = \JetPHP\Model\DB::execute($this->query);

                if ($query->count() > 0) {
                    $this->records[] = [];
                    $i = 0;

                    while ($row = $query->list(PDO::FETCH_OBJ)) {
                        foreach ($row as $column=>$value) {
                            if (in_array($column, array_keys($this->fields))) {
                                $this->records[$i][$column] = $value;
                            }
                        }
                        $i++;
                    }

                    $this->render();
                } else {
                    echo "Query error";
                }

            } else if ($this->table != false) {
                $sdb = new StaticDB();
                $tbl = $sdb->{$this->table};
                $qr  = $tbl()->show('all');

                $i = 0;
                foreach ($qr as $row) {
                    foreach ($row as $column=>$value) {
                        if (isset($this->fields[$column]) and in_array('L',str_split($this->fields[$column]['action']))) {
                            $this->records[$i][$column] = $value;
                        }
                    }
                    $i++;
                }

                $this->render();
            } else {

            }

            return $this;
        }

        private function generateTableHeader() {
            if (count($this->fields) > 0 and count($this->records) > 0) {
                $this->t_header .= "<tr>";
                    foreach ($this->records[0] as $column=>$value) {
                        $this->t_header .= "<th>".$this->fields[$column]['title']."</th>";
                    }
                $this->t_header .= "<th>Ação</th>";
                $this->t_header .= "</tr>";
            }
            return $this;
        }

        private function generateTableBody() {
            if (count($this->records) > 0) {
                    foreach ($this->records as $count=>$record) {
                        $this->t_body .= "<tr>";
                        foreach ($record as $field=>$value) {
                            $this->t_body .= "<td>".$value."</td>";
                        }

                        $this->t_body .= $this->actionButtons($record['id']);
                        $this->t_body .= "</tr>";
                    }
            }
            return $this;
        }

        private function actionButtons($id) {
            $t = '<td>';
            if (strstr($this->allowed_actions,'U')) {
                // Check if Update is allowed
                $t .= '<a href="?acao=edit&id='.$id.'" class="btn btn-success btn-circle"> <i class="fa fa-pencil"></i> </a>';
            }
            if (strstr($this->allowed_actions,'D')) {
                // Check if Delete is allowed
                $t .= '<a href="?acao=delete&id='.$id.'" class="btn btn-danger btn-circle"> <i class="fa fa-times"></i> </a>';
            }
            $t .= '</td>';

            return $t;
        }

        public function generateTable() {
            $this->generateTableHeader();
            $this->generateTableBody();

            $t  = "<table class='table'>";
            $t .= $this->t_header;
            $t .= $this->t_body;
            $t .= "</table>";

            echo $t;
        }

        // ------- End listView method -------

        // ------- deleteView method -------

        public function deleteView() {
          if ($this->query != false) {
            $query = explode(" ",$this->query);
            $table = $query[3];
            $id    = Start::get('id');

            \JetPHP\Model\DB::execute("DELETE FROM {$table} WHERE id=:id",['id'=>$id]);
            echo "<script>history.back();</script>";
          } else if ($this->table != false) {
            $id    = Start::get('id');
            \JetPHP\Model\DB::execute("DELETE FROM {$this->table} WHERE id=:id",['id'=>$id]);
            echo "<script>history.back();</script>";
          } else {}
        }

        // ------- End deleteView method -------




        // ------- addView method -------
        public function addView() {
            if ($this->query != false) {
              $query = explode(" ",$this->query);
              $this->table = $query[3];
            } else if ($this->table != false) {

            } else {

            }
            $columns = [];
            $f_columns = [];
            $qr = \JetPHP\Model\DB::execute("SELECT DISTINCT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = :table", ['table'=>$this->table]);
            if ($qr->count() > 0) {
                while($r = $qr->list(PDO::FETCH_OBJ)) {
                    $columns[] = $r->COLUMN_NAME;
                }
            }
            if (isset($columns) and count($columns) > 0) {
                $i = 0;
                foreach ($columns as $column) {
                    if (isset($this->fields[$column])) {
                        $qr = \JetPHP\Model\DB::execute("SELECT DISTINCT DATA_TYPE as type,CHARACTER_MAXIMUM_LENGTH as max FROM information_schema.COLUMNS WHERE TABLE_NAME = :t and COLUMN_NAME = '{$column}'", ['t' => $this->table]);
                        $r  = $qr->list();

                        $f_columns[$i] = [];
                        $f_columns[$i]['title']  = $this->fields[$column]['title'];
                        $f_columns[$i]['name']   = $this->fields[$column]['field'];
                        $f_columns[$i]['action'] = str_split($this->fields[$column]['action']);

                        if (isset($this->fields[$column]['class'])):
                            $f_columns[$i]['class'] = $this->fields[$column]['class'];
                        endif;
                        if (isset($this->fields[$column]['disabled'])):
                            $f_columns[$i]['disabled'] = $this->fields[$column]['disabled'];
                        endif;
                        $f_columns[$i]['type'] = $r->type;
                        $f_columns[$i]['max']  = ($r->max != null) ? $r->max : 11;

                        $i++;
                    }
                }
                $this->f_columns = $f_columns;
            } else {
                ?>
                <p>An error ocurred.</p>
                <?php
            }


            $this->render('add');

            return $this;
        }

        private function generateAddFields() {
            if (isset($this->f_columns) and count($this->f_columns) > 0) {
                $f  = "<form method='post' action=''>";
                    foreach ($this->f_columns as $column) {
                        if (in_array('I', $column['action'])) {
                            $type = $this->getFormType($column['type']);
                            $class = (isset($column['class'])) ? 'class="'.$column['class'].'"' : '';
                            $f .= "<div class='input-group'>";
                                $f .= "<label>{$column['title']}:";
                                if ($type == 'textarea') {
                                    $f.= "<textarea name='{$column['name']}' {$class} max='{$column['max']}'></textarea>";
                                } else {
                                    $f.= "<input name='{$column['name']}' type='{$type}' {$class} max='{$column['max']}'>";
                                }
                                $f .= "</label>";
                            $f .= "</div>";
                        }
                    }
                $f .= "</form>";

                echo $f;
            } else {
            ?>
            <p>An error ocurred.</p>
            <?php
            }
        }

        // ------- End addView method -------



        // ------- Begin editView -------

        public function editView() {

            if (Start::get('id') != '' && Start::get('id') != false && Start::get('id') != null) {
                if ($this->query != false) {
                  $query = explode(" ",$this->query);
                  $this->table = $query[3];
                } else if ($this->table != false) {

                } else {

                }

                $sdb = new StaticDB();
                $tbl = $sdb->{$this->table};
                $edt = $tbl()->show(Start::get('id'));

                $columns = [];
                $f_columns = [];
                $qr = \JetPHP\Model\DB::execute("SELECT DISTINCT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = :table", ['table'=>$this->table]);
                if ($qr->count() > 0) {
                    while($r = $qr->list(PDO::FETCH_OBJ)) {
                        $columns[] = $r->COLUMN_NAME;
                    }
                }
                if (isset($columns) and count($columns) > 0) {
                    $i = 0;
                    foreach ($columns as $column) {
                        if (isset($this->fields[$column])) {
                            $qr = \JetPHP\Model\DB::execute("SELECT DISTINCT DATA_TYPE as type,CHARACTER_MAXIMUM_LENGTH as max FROM information_schema.COLUMNS WHERE TABLE_NAME = :t and COLUMN_NAME = '{$column}'", ['t' => $this->table]);
                            $r  = $qr->list();

                            $f_columns[$i] = [];
                            $f_columns[$i]['title']  = $this->fields[$column]['title'];
                            $f_columns[$i]['name']   = $this->fields[$column]['field'];
                            $f_columns[$i]['action'] = str_split($this->fields[$column]['action']);
                            $f_columns[$i]['value']  = (isset($edt->{$f_columns[$i]['name']})) ? $edt->{$f_columns[$i]['name']} : '';

                            if (isset($this->fields[$column]['class'])):
                                $f_columns[$i]['class'] = $this->fields[$column]['class'];
                            endif;
                            if (isset($this->fields[$column]['disabled'])):
                                $f_columns[$i]['disabled'] = $this->fields[$column]['disabled'];
                            endif;
                            $f_columns[$i]['type'] = $r->type;
                            $f_columns[$i]['max']  = ($r->max != null) ? $r->max : 11;

                            $i++;
                        }
                    }
                    $this->f_columns = $f_columns;
                } else {
                    ?>
                    <p>An error ocurred.</p>
                    <?php
                }


                $this->render('edit');
            } else {
                $this->render('error');
            }

            return $this;
        }


        private function generateEditFields() {
            if (isset($this->f_columns) and count($this->f_columns) > 0) {
                $f  = "<form method='post' action=''>";
                    foreach ($this->f_columns as $column) {
                        $field_value = (isset($this->fields[$column['name']]['value'])) ? $this->fields[$column['name']]['value'] : $column['value'];


                        if (in_array('I', $column['action'])) {
                            $type = $this->getFormType($column['type']);
                            $class = (isset($column['class'])) ? 'class="'.$column['class'].'"' : '';
                            $f .= "<div class='input-group'>";
                                $f .= "<label>{$column['title']}:";
                                if ($type == 'textarea') {
                                    $f.= "<textarea name='{$column['name']}' {$class} max='{$column['max']}'>".$field_value."</textarea>";
                                } else {
                                    $f.= "<input name='{$column['name']}' value='".$field_value."' type='{$type}' {$class} max='{$column['max']}'>";
                                }
                                $f .= "</label>";
                            $f .= "</div>";
                        }
                    }
                $f .= "</form>";

                echo $f;
            } else {
            ?>
            <p>An error ocurred.</p>
            <?php
            }
        }

        // ------- End editView -------




        private function getFormType($t) {
            switch ($t) {
                case 'varchar':
                    return 'text';
                    break;
                case 'int':
                    return 'number';
                    break;
                case 'text':
                    return 'textarea';
                    break;
            }
        }

        private function render($type='list') {
            include '../app/view/admin/inc/topo.phtml';
            include '../app/view/admin/inc/menu.phtml';

            // $add   = $this->add;
            $title = $this->title;
            include '../app/view/admin/inc/_base.phtml';

            if ($type == 'list') {
                $this->generateTable();
            } else if ($type == 'add') {
                $this->generateAddFields();
            } else if ($type == 'edit') {
                $this->generateEditFields();
            }  else if ($type == 'error') {
                echo "<p>An error ocurred.</p>";
            } else {}

            include '../app/view/admin/inc/rodape1.phtml';

            return $this;
        }
    }

?>
