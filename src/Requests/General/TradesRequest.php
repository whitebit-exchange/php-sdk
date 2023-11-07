<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\General;

use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use WhiteBIT\Sdk\DTO\Response\TradeItemDTO;
use WhiteBIT\Sdk\Enums\OrderTypeEnum;

final class TradesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $market, protected ?OrderTypeEnum $type = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/api/v4/public/trades/'.$this->market;
    }

    protected function defaultQuery(): array
    {
        return [
            'type' => $this->type?->value,
        ];
    }

    /**
     * @throws \Exception
     */
    public function createDtoFromResponse(Response $response): array
    {
        $data = $response->json();
        $result = [];

        foreach ($data as $trade) {
            $result[] = TradeItemDTO::fromResponseJson($trade);
        }

        return $result;
    }
}
