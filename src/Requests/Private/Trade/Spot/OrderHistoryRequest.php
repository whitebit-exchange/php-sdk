<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Trade\Spot;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

final class OrderHistoryRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/trade-account/order/history';
    }

    public function __construct(
        protected ?string $market = null,
        protected ?string $orderId = null,
        protected ?string $clientOrderId = null,
        protected ?int $offset = null,
        protected ?int $limit = null,
    ) {
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'offset' => $this->offset,
            'limit' => $this->limit,
            'market' => $this->market,
            'orderId' => $this->orderId,
            'clientOrderId' => $this->clientOrderId,
        ], static fn (mixed $item): bool => $item !== null);
    }
}
