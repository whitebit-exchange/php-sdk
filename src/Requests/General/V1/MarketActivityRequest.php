<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\General\V1;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * @deprecated This endpoint will be deprecated soon.
 */
final class MarketActivityRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v1/public/tickers';
    }
}
