<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private;

use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use WhiteBIT\Sdk\DTO\Response\AddressDTO;

final class AddressRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected string $ticker, protected ?string $network = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/api/v4/main-account/address';
    }

    protected function defaultBody(): array
    {
        return [
            'ticker' => $this->ticker,
            'network' => $this->network,
        ];
    }

    public function createDtoFromResponse(Response $response): AddressDTO
    {
        return AddressDTO::fromResponseJson($response->json());
    }
}
