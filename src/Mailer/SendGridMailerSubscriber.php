<?php

namespace HelloBetter\SendGridMailer\Mailer;

use SilverStripe\Control\Email\Email;
use SilverStripe\Control\Email\MailerSubscriber;
use SilverStripe\Core\Environment;

class SendGridMailerSubscriber extends MailerSubscriber
{

    private function setTo(Email $email, array $sendAllTo): void
    {
        $headers = $email->getHeaders();

        $testEmail = Environment::getEnv('SENDGRID_TEST_EMAIL');
        if ($testEmail) {
            $email->to($testEmail);
            $email->cc([]);
            $email->bcc([]);
        } else {
            // store the old data as X-Original-* Headers for debugging
            if (!empty($email->getTo())) {
                $headers->addMailboxListHeader('X-Original-To', $email->getTo());
            }
            if (!empty($email->getCc())) {
                $headers->addMailboxListHeader('X-Original-Cc', $email->getCc());
            }
            if (!empty($email->getBcc())) {
                $headers->addMailboxListHeader('X-Original-Bcc', $email->getBcc());
            }
            // set default recipient and remove all other recipients
            $email->to(...$sendAllTo);
            $email->cc(...[]);
            $email->bcc(...[]);
        }
    }

}
