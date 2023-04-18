<?php

namespace App\Components\MailerLite;

use App\Components\MailerLite\Endpoints\Account;

class MailerLite extends \MailerLite\MailerLite
{
    public Account $account;

    protected function setEndpoints(): void
    {
        parent::setEndpoints();
        $this->account = new Account($this->httpLayer, $this->options);
    }
}
