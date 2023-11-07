<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\General;

use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use WhiteBIT\Sdk\DTO\Response\MarketDTO;

final class MarketsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/public/markets';
    }

    public function createDtoFromResponse(Response $response): array
    {
        $data = $response->json();
        $result = [];

        foreach ($data as $market) {
            $result[] = MarketDTO::fromResponseJson($market);
        }

        return $result;
    }
}
