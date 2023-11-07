<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Trade\Spot;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class OrderDealsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/trade-account/order';
    }

    public function __construct(
        protected string $orderId,
        protected ?int $offset = null,
        protected ?int $limit = null,
    ) {
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'orderId' => $this->orderId,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ], static fn (mixed $item): bool => $item !== null);
    }
}
