<?php declare(strict_types=1);

namespace App\Helper;

use League\Plates\Engine;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class EmailHelper
{

    public function __construct(
        protected Engine $templates,
        protected PHPMailer $mailer
    )
    {
    }

    public function sendMail(
        string $template,
        string $recipientEmail,
        string $subject,
        array $data,
        string $altBody = ''
    ): bool
    {

        try {

            $this->mailer->addAddress($recipientEmail, ($data['username'] ?? ''));
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $this->templates->render('email/' . $template , $data);
            $this->mailer->AltBody = $altBody;
            $this->mailer->send();
            return true;

        } catch (Exception $exception) {

            return false;

        }

    }

}
