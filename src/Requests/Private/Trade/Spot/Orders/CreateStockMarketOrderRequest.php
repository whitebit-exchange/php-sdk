<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Trade\Spot\Orders;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use WhiteBIT\Sdk\DTO\Response\Private\Trade\SpotOrderDTO;
use WhiteBIT\Sdk\Enums\OrderTypeEnum;

final class CreateStockMarketOrderRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/order/stock_market';
    }

    public function __construct(
        protected string $market,
        protected OrderTypeEnum $side,
        protected string $amount,
        protected ?string $clientOrderId = null,
    ) {
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'market' => $this->market,
            'side' => $this->side,
            'clientOrderId' => $this->clientOrderId,
            'amount' => $this->amount,
        ], static fn (mixed $item): bool => $item !== null);
    }

    public function createDtoFromResponse(Response $response): SpotOrderDTO
    {
        return SpotOrderDTO::fromResponseJson($response->json());
    }
}
