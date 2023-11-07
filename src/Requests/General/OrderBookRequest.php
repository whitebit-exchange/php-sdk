<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\General;

use LogicException;
use Saloon\Enums\Method;
use Saloon\Http\Request;

final class OrderBookRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $market,
        protected int $depth = 0,
        protected int $limit = 100
    ) {
        if ($this->depth < 0) {
            throw new LogicException("Depth can't be less than 0");
        }

        if ($this->depth > 5) {
            throw new LogicException("Depth can't be more than 5");
        }
    }

    public function resolveEndpoint(): string
    {
        return '/api/v4/public/orderbook/'.$this->market;
    }

    protected function defaultQuery(): array
    {
        return [
            'depth' => $this->depth,
            'limit' => $this->limit,
        ];
    }
}
