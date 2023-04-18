<?php

namespace App\Resolvers;

use App\DTOs\GetSubscribersDto;
use Carbon\Carbon;

class SubscribersResolver
{
    /**
     * @param array $subscribers
     * @param GetSubscribersDto $dto
     * @param int $subscribersTotal
     * @return array
     */
    public function resolveAPIData(array $subscribers, GetSubscribersDto $dto, int $subscribersTotal)
    {
        $filteredData = array_map(function ($item) {
            if ($subscribedAt = $item['subscribed_at'] ?? null) {
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $subscribedAt);
            }

            return [
                $item['email'] ?? null,
                ($item['fields']['name'] ?? '') . ' ' . ($item['fields']['last_name'] ?? ''),
                $item['fields']['country'] ?? '',
                isset($date) ? $date->format('d/m/Y') : '',
                isset($date) ? $date->format('H:i:s') : '',
                $item['id'] ?? null,
            ];
        }, $subscribers['data'] ?? []);

        $dataCount = count($filteredData);

        return [
            'draw' => $dto->draw,
            'recordsTotal' => $subscribersTotal,
            'recordsFiltered' => $dataCount,
            'data' => $filteredData,
            'next_cursor' => $subscribers['meta']['next_cursor'] ?? null,
            'prev_cursor' => $subscribers['meta']['prev_cursor'] ?? null,
            'per_page' => $subscribers['meta']['per_page'] ?? null,
        ];
    }
}
