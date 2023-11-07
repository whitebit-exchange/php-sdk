<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\General\V1;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use WhiteBIT\Sdk\Enums\KlineIntervalEnum;

final class KlineRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v1/public/kline';
    }

    public function __construct(
        protected string $market,
        protected ?int $start = null,
        protected ?int $end = null,
        protected ?KlineIntervalEnum $interval = null,
        protected ?int $limit = null,
    ) {
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'market' => $this->market,
            'start' => $this->start,
            'end' => $this->end,
            'interval' => $this->interval,
            'limit' => $this->limit,
        ], static fn (mixed $item): bool => $item !== null);
    }
}
