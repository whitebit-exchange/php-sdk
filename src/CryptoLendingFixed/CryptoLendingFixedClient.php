<?php

namespace Whitebit\CryptoLendingFixed;

use Psr\Http\Client\ClientInterface;
use Whitebit\Core\Client\RawClient;
use Whitebit\Environments;
use Whitebit\CryptoLendingFixed\Requests\GetFixedPlansRequest;
use Whitebit\Types\FixedPlan;
use Whitebit\Exceptions\WhitebitException;
use Whitebit\Exceptions\WhitebitApiException;
use Whitebit\Core\Json\JsonApiRequest;
use Whitebit\Core\Client\HttpMethod;
use Whitebit\Core\Json\JsonDecoder;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Whitebit\CryptoLendingFixed\Requests\CreateFixedInvestmentRequest;
use Whitebit\CryptoLendingFixed\Types\CreateFixedInvestmentResponse;
use Whitebit\CryptoLendingFixed\Requests\CloseFixedInvestmentRequest;
use Whitebit\CryptoLendingFixed\Requests\GetFixedInvestmentsHistoryRequest;
use Whitebit\CryptoLendingFixed\Types\GetFixedInvestmentsHistoryResponse;
use Whitebit\CryptoLendingFixed\Requests\GetInterestPaymentHistoryRequest;
use Whitebit\CryptoLendingFixed\Types\GetInterestPaymentHistoryResponse;

class CryptoLendingFixedClient
{
    /**
     * @var array{
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options @phpstan-ignore-next-line Property is used in endpoint methods via HttpEndpointGenerator
     */
    private array $options;

    /**
     * @var RawClient $client
     */
    private RawClient $client;

    /**
     * @var Environments $environment
     */
    private Environments $environment;

    /**
     * @param RawClient $client
     * @param Environments $environment
     */
    public function __construct(
        RawClient $client,
        Environments $environment,
    ) {
        $this->client = $client;
        $this->environment = $environment;
        $this->options = [];
    }

    /**
     * The endpoint returns investment plan configurations with active status and API access enabled, filtered by the authenticated user's region and plan visibility. Results include public plans and private plans assigned to the account.
     *
     * <Note>
     * These endpoints are available only for B2B partner services. Fill the institutional services form to get permissions to use these endpoints.
     * </Note>
     *
     * **Note:** When target currency is different from source currency, interest amount in target currency will be calculated using `interestRatio` value.
     *
     * **Examples:**
     * - When source currency = USDT, target currency = BTC and interest ratio = 40000, interest is received in BTC and equals the USDT interest amount divided by the interest ratio (e.g. 0.000025 BTC per 1 USDT of interest).
     * - When source currency equals target currency, interest ratio equals 1.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param GetFixedPlansRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<FixedPlan>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getFixedPlans(GetFixedPlansRequest $request, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/smart/plans",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [FixedPlan::class]); // @phpstan-ignore-line
            }
        } catch (JsonException $e) {
            throw new WhitebitException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new WhitebitException(message: $e->getMessage(), previous: $e);
        }
        throw new WhitebitApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * The endpoint creates a new investment to the specified [invest plan](/glossary#crypto-lending).
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param CreateFixedInvestmentRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CreateFixedInvestmentResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createFixedInvestment(CreateFixedInvestmentRequest $request, ?array $options = null): CreateFixedInvestmentResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/smart/investment",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CreateFixedInvestmentResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new WhitebitException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new WhitebitException(message: $e->getMessage(), previous: $e);
        }
        throw new WhitebitApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * The endpoint closes active investment.
     *
     * Early closure is allowed and carries no penalty — the request either succeeds or returns one of the documented errors.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param CloseFixedInvestmentRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<string, mixed>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function closeFixedInvestment(CloseFixedInvestmentRequest $request, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/smart/investment/close",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, ['string' => 'mixed']); // @phpstan-ignore-line
            }
        } catch (JsonException $e) {
            throw new WhitebitException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new WhitebitException(message: $e->getMessage(), previous: $e);
        }
        throw new WhitebitApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * The endpoint retrieves an investments history.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param GetFixedInvestmentsHistoryRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetFixedInvestmentsHistoryResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getFixedInvestmentsHistory(GetFixedInvestmentsHistoryRequest $request, ?array $options = null): GetFixedInvestmentsHistoryResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/smart/investments",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetFixedInvestmentsHistoryResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new WhitebitException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new WhitebitException(message: $e->getMessage(), previous: $e);
        }
        throw new WhitebitApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * The endpoint retrieves the history of interest payments.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param GetInterestPaymentHistoryRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetInterestPaymentHistoryResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getInterestPaymentHistory(GetInterestPaymentHistoryRequest $request, ?array $options = null): GetInterestPaymentHistoryResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/smart/interest-payment-history",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetInterestPaymentHistoryResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new WhitebitException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new WhitebitException(message: $e->getMessage(), previous: $e);
        }
        throw new WhitebitApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }
}
