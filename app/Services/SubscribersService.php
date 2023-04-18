<?php

namespace App\Services;

use App\DTOs\GetSubscribersDto;

class SubscribersService extends MailerLiteService
{
    /**
     * @param GetSubscribersDto $subscribersDto
     * @return array|null
     */
    public function getAllSubscribers(GetSubscribersDto $subscribersDto): ?array
    {
        if ($subscribersDto->search) {
            try {
                if ($subscriber = $this->getSubscriberByEmailOrId($subscribersDto->search)) {
                    $subscriber['data'] = [$subscriber['data']];
                    return $subscriber;
                }
            } catch (\Throwable $e) {
            }
        }

        $subscribers = $this->mailerLite->subscribers->get([
            'limit' => $subscribersDto->length,
            'cursor' => $subscribersDto->cursor,
        ]);

        return $subscribers['body'] ?? null;
    }

    /**
     * @return int
     */
    public function getSubscribersTotal(): int
    {
        return $this->mailerLite->subscribers->get(['limit' => 0])['body']['total'] ?? 1;
    }

    /**
     * @param string $input
     * @return array|null
     */
    public function getSubscriberByEmailOrId(string $input): ?array
    {
        try {
            $subscriber = $this->mailerLite->subscribers->find(urlencode($input));
        } catch (\Throwable $e) {
        }

        return $subscriber['body'] ?? null;
    }

    /**
     * @param array $data
     * @return array|null
     */
    public function createOrUpsertSubscriber(array $data): ?array
    {
        return $this->mailerLite->subscribers->create($data)['body']['data'] ?? null;
    }

    /**
     * @param string $id
     * @param array $data
     * @return array|null
     */
    public function updateSubscriber(string $id, array $data): ?array
    {
        return $this->mailerLite->subscribers->update($id, $data)['body']['data'] ?? null;
    }

    /**
     * @param string $id
     * @return string|null
     */
    public function deleteSubscriber(string $id): ?string
    {
        return $this->mailerLite->subscribers->delete($id)['status_code'] ?? null;
    }
}
