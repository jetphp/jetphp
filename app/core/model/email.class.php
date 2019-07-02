<?php
  namespace JetPHP\Model;
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  class Email {
    public static $email = '';

    public function start() {
      self::$email = new PHPMailer();
      self::$email->isSMTP();
      self::$email->Host = \JetPHP\Model\Config::show('SMTP_HOST');
      self::$email->SMTPAuth = true;
      self::$email->SMTPSecure = 'tls';
      self::$email->Username = \JetPHP\Model\Config::show('SMTP_USUARIO');
      self::$email->Password = \JetPHP\Model\Config::show('SMTP_SENHA');
      self::$email->Port = \JetPHP\Model\Config::show('SMTP_PORTA');
      self::$email->setFrom(Config::show('SMTP_EMAILPRINCIPAL'),Config::show('TITULO'));
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
