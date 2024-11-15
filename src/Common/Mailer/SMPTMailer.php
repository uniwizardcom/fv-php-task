<?php

namespace App\Common\Mailer;

class SMPTMailer implements MailerInterface
{
    public function send(string $recipient, string $subject, string $message): void
    {
        echo "Sending email to $recipient\n";
    }
}
