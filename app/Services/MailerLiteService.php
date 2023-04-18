<?php

namespace App\Services;

use MailerLite\MailerLite;

class MailerLiteService
{
    protected MailerLite $mailerLite;

    /**
     * MailerLiteService constructor.
     * @param MailerLite $mailerLite
     */
    public function __construct(MailerLite $mailerLite)
    {
        $this->mailerLite = $mailerLite;
    }
}
