<?php
    class JetFormUsuarios extends JetForms {
        public function __construct() {
            $this->initForm("administrador_usuarios");
            $this->title = 'Usuários';

            $f = $this->addField('id','L');
            $f->addProperty('title','#');
            $f->addClass('form-control');

            $f = $this->addField('email');
            $f->addProperty('title','Email');
            $f->addClass('form-control');

            $f = $this->addField('nome');
            $f->addProperty('title','Nome do usuário');
            $f->addClass('form-control');



            $this->loadForm();

            mostrar($this);
        }
    }
?>