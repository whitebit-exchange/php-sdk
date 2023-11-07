<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private\Main;

final class CreateWithdrawPayRequest extends CreateWithdrawRequest
{
    public function resolveEndpoint(): string
    {
        return '/api/v4/main-account/withdraw-pay';
    }
}
