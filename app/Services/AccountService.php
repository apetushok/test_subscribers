<?php

namespace App\Services;

use App\Components\MailerLite\MailerLite;
use App\Models\User;

class AccountService
{
    protected MailerLite $mailerLite;

    /**
     * @param MailerLite $mailerLite
     */
    public function setMailerLite(MailerLite $mailerLite)
    {
        $this->mailerLite = $mailerLite;
    }

    /**
     * @return array|null
     */
    public function getOwnerDataByApiKey(): ?array
    {
        return $this->mailerLite->account->get()['body']['data'] ?? null;
    }

    /**
     * @param string|null $apiKey
     * @param array|null $owner
     * @return User
     */
    public function upsertUserWithApiKey(?string $apiKey, ?array $owner): User
    {
        if (!$apiKey || !$owner || empty($owner['sender_email'])) {
            throw new \InvalidArgumentException('Api key was not found');
        }

        if ($user = User::where('email', $owner['sender_email'])->first()) {
            $user->mailer_lite_api_key = $apiKey;
            $user->save();
            return $user;
        }

        return User::create([
            'name' => $owner['name'] ?? '',
            'password' => '',
            'email' => $owner['sender_email'],
            'mailer_lite_api_key' => $apiKey
        ]);
    }
}
