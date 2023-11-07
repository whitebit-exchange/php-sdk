<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Trade\Spot\Orders;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use WhiteBIT\Sdk\DTO\Response\Private\Trade\SpotOrderDTO;

final class CancelOrderRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/order/cancel';
    }

    public function __construct(
        protected string $market,
        protected string $orderId,
    ) {
    }

    protected function defaultBody(): array
    {
        return [
            'market' => $this->market,
            'orderId' => $this->orderId,
        ];
    }

    public function createDtoFromResponse(Response $response): SpotOrderDTO
    {
        return SpotOrderDTO::fromResponseJson($response->json());
    }
}
