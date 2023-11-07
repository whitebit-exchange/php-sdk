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

final class CreateLimitOrderRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/order/new';
    }

    public function __construct(
        protected string $market,
        protected OrderTypeEnum $side,
        protected string $amount,
        protected string $price,
        protected ?bool $postOnly = null,
        protected ?bool $ioc = null,
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
            'price' => $this->price,
        ], static fn (mixed $item): bool => $item !== null);
    }

    public function createDtoFromResponse(Response $response): SpotOrderDTO
    {
        return SpotOrderDTO::fromResponseJson($response->json());
    }
}
