<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\General\V1;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * @deprecated This endpoint will be deprecated soon.
 */
final class SingleMarketActivityRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $market)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/api/v1/public/ticker';
    }

    protected function defaultQuery(): array
    {
        return [
            'market' => $this->market,
        ];
    }
}
