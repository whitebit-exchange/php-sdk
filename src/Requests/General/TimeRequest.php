<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\General;

use Saloon\Enums\Method;
use Saloon\Http\Request;

final class TimeRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/public/time';
    }
}
