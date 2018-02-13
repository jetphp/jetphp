<?php
  /*
  * @author João Artur
  * @description www.joaoartur.com - www.github.com/JoaoArtur
  */
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  class Email {
    public static $email = '';

    public function email() {
      self::$email = new PHPMailer();
      self::$email->isSMTP();
      self::$email->Host = Config::mostrar('SMTP_HOST');
      self::$email->SMTPAuth = true;
      self::$email->SMTPSecure = 'tls';
      self::$email->Username = Config::mostrar('SMTP_USUARIO');
      self::$email->Password = Config::mostrar('SMTP_SENHA');
      self::$email->Port = 587;
      self::$email->setFrom(Config::mostrar('SMTP_EMAILPRINCIPAL'),Config::mostrar('TITULO'));
      self::$email->isHTML(true);
    }
    public function adicionarDestinatario($destinatario) {
      if (is_array($destinatario)) {
        if (is_array($destinatario[0])) {
          foreach ($destinatario as $valor) {
            self::$email->addAddress($valor[0], $valor[1]);
          }
        } else {
          self::$email->addAddress($destinatario[0], $destinatario[1]);
        }
      } else {
        self::$email->addAddress($destinatario);
      }
    }
    public function setarAssunto($assunto) {
      self::$email->Subject = $assunto;
    }
    public function responder($email) {
      self::$email->addReplyTo($email);
    }
    public function setarMensagem($msg) {
      self::$email->Body    = $msg;
      self::$email->AltBody = $msg;
      self::$email->CharSet = "UTF-8";
    }
    public function enviar() {
      return self::$email->send();
    }
  }
?>
