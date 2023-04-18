<?php

namespace App\Components\MailerLite\Endpoints;

use MailerLite\Endpoints\AbstractEndpoint;

class Account extends AbstractEndpoint
{
    protected string $endpoint = 'account';

    /**
     * @param array $params
     * @return array
     */
    public function get(array $params = []): array
    {
        return $this->httpLayer->get(
            $this->buildUri($this->endpoint, $params)
        );
    }
}
