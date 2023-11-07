<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\Requests\Private;

use Illuminate\Support\Collection;
use Saloon\Contracts\Body\HasBody;
use Saloon\Contracts\Response;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use WhiteBIT\Sdk\DTO\Response\MainBalanceDTO;

final class MainBalanceRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected ?string $ticker = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/api/v4/main-account/balance';
    }

    protected function defaultBody(): array
    {
        return array_filter([
            'ticker' => $this->ticker,
        ]);
    }

    /**
     * @return Collection<MainBalanceDTO>
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        $data = $response->json();
        $result = new Collection();

        foreach ($data as $ticker => $payload) {
            $result[] = MainBalanceDTO::fromResponseJson($ticker, $payload);
        }

        return $result;
    }
}
