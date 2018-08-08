<?php
  namespace JetPHP\Model;
  class JCaptcha {
    public function __construct() {
      if (isset($_SESSION['captcha'])) {
        if (isset($_POST) and count($_POST) > 0) {
          if (isset($_POST['captcha']) and $_POST['captcha'] == base64_decode($_SESSION['captcha'])) {

          } else {
            echo "Você precisa preencher o captcha";
            die();
          }
        }
      }
      $this->gerar();
    }
    public function gerar() {
      $size = 5;
      $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuwxyz0123456789";
      $randomString = '';
      for($i = 0; $i < $size; $i = $i+1) {
        $randomString .= $chars[mt_rand(0,60)];
      }
      $base = base64_encode(strtoupper($randomString));
      $_SESSION['captcha'] = $base;
    }
  }
  abstract class JCaptchaInput {
    public static function imagem() {
      ob_start();
        $captcha = base64_decode($_SESSION['captcha']);
        $im = imagecreate(220, 60);
        $bg = imagecolorallocate($im, 52, 73, 94);
        $textcolor = imagecolorallocate($im, 236, 240, 241);

        imagestring($im, 200, 80, 20, $captcha, $textcolor);
        imagepng($im);
        $conteudo = ob_get_contents();
      ob_end_clean();
      return "data:image/png;base64,".base64_encode($conteudo);
    }
    public static function gerarCampo() {
      $captcha = "
        <div class='row'>
          <div class='col-md-3' style='max-width: 250px'>
            <img src='".self::imagem()."'>
            <input class='form-control' type='text' name='captcha' placeholder='Digite o que vê na imagem'>
          </div>
        </div>
      ";
      echo $captcha;
    }
  }
?>
