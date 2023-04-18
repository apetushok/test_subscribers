<?php

namespace App\DTOs;

use Illuminate\Support\Arr;

class GetSubscribersDto
{
    public int $draw;
    public array $columns;
    public array $order;
    public int $start;
    public int $length;
    public ?string $search;
    public ?string $cursor;

    public function __construct(array $subscribersData)
    {
        $this->draw = Arr::get($subscribersData, 'draw', 1);
        $this->columns = $subscribersData['columns'] ?? [];
        $this->order = $subscribersData['order'][0] ?? [];
        $this->start = Arr::get($subscribersData, 'start', 0);
        $this->length = Arr::get($subscribersData, 'length', 10);
        $this->search = $subscribersData['search']['value'] ?? null;
        $this->cursor = $subscribersData['cursor'] ?? null;
    }
}
