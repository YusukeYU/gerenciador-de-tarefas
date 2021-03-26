<?php

namespace Src;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Mailer{
  private $mail;

  public function __construct()
  {
    $this->mail = new PHPMailer();
    $this->mail->isSMTP();
    $this->mail->SMTPDebug = 0;
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->Port = 587;
    $this->mail->SMTPAuth = true;
    $this->mail->Username = 'yourmail@gmail.com';
    $this->mail->Password = 'yourpassword';
    $this->mail->setFrom('yourmail@gmail.com', 'Your Name');
    $this->mail->addReplyTo('yourmail@gmail.com', 'Your Name');
  }

  public function sendMailResetPassword($destiny,$link){
      try{
        require __DIR__ . '/../Public/Mail/resetPassword.php';
        $this->mail->Subject = 'Recuperar Senha';
        $this->mail->Body = $mail_template;
        $this->mail->IsHTML(true); 
        $this->mail->addAddress($destiny);
        $this->mail->send();
      } catch(Exception $e){
          return $e->getMessage();
      }
      return 1;
  }
}