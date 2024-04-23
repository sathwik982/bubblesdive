<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../config/config.php';
// require '../vendor/autoload.php';
require __DIR__ . '/../../vendor/autoload.php';


class Mail
{
    protected $mail;
    public function __construct()
    {
        $config = getMailConfig();
        $this->initiate($config);
    }

    private function initiate($config)
    {

        require_once __DIR__ . '/../../vendor/phpmailer/phpmailer/src/SMTP.php';

        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->Host     = $config["Host"];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $config["Username"];
        $this->mail->Password = $config["Password"];
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = $config["PORT"];

        $this->mail->setFrom($config["From"], $config["FromName"]);
        $this->mail->isHTML(true);
    }
    public function send(string $to, string $subject, string $body)
    {
        try {
            $this->mail->addAddress($to);

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->send();
            return ["success" => true];
        } catch (Exception $e) {
            return ["success" => false, "msg" => "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}"];
        }
    }
}
