<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\General\V1;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * @deprecated This endpoint will be deprecated soon.
 */
final class TradeHistoryRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $market,
        protected string $lastId,
        protected ?int $limit = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/api/v1/public/history';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'market' => $this->market,
            'lastId' => $this->lastId,
            'limit' => $this->limit,
        ], static fn (mixed $item): bool => $item !== null);
    }
}
