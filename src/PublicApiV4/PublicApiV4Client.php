<?php

namespace Whitebit\PublicApiV4;

use Psr\Http\Client\ClientInterface;
use Whitebit\Core\Client\RawClient;
use Whitebit\Environments;
use Whitebit\PublicApiV4\Types\GetApiV4PublicPlatformStatusResponse;
use Whitebit\Exceptions\WhitebitException;
use Whitebit\Exceptions\WhitebitApiException;
use Whitebit\Core\Json\JsonApiRequest;
use Whitebit\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Whitebit\PublicApiV4\Types\GetApiV4PublicMarketsResponseItem;
use Whitebit\Core\Json\JsonDecoder;
use Whitebit\PublicApiV4\Types\GetApiV4PublicTickerResponseValue;
use Whitebit\Types\Asset;
use Whitebit\PublicApiV4\Requests\GetApiV4PublicOrderbookMarketRequest;
use Whitebit\Types\OrderbookResponse;
use Whitebit\PublicApiV4\Requests\GetApiV4PublicTradesMarketRequest;
use Whitebit\PublicApiV4\Types\GetApiV4PublicTradesMarketResponseItem;
use Whitebit\Types\FeeInfo;
use Whitebit\PublicApiV4\Types\GetApiV4PublicTimeResponse;
use Whitebit\PublicApiV4\Types\GetApiV4PublicCollateralMarketsResponse;
use Whitebit\PublicApiV4\Types\GetApiV4PublicFuturesResponse;
use Whitebit\PublicApiV4\Requests\GetApiV4PublicFundingHistoryMarketRequest;
use Whitebit\PublicApiV4\Types\GetApiV4PublicFundingHistoryMarketResponseItem;
use Whitebit\PublicApiV4\Types\GetApiV4PublicMiningPoolResponse;

class PublicApiV4Client
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
     * The endpoint retrieves the current maintenance status of the WhiteBIT platform. Use the response to detect scheduled downtime and pause trading automation during maintenance windows. The `status` field returns `"system operational"` when all platform services are available, or `"system maintenance"` when the platform is undergoing planned maintenance.
     *
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetApiV4PublicPlatformStatusResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function maintenanceStatus(?array $options = null): GetApiV4PublicPlatformStatusResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/platform/status",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetApiV4PublicPlatformStatusResponse::fromJson($json);
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
     * The endpoint retrieves configuration and trading rules for all available spot and futures markets (TradFi futures markets are coming soon and are not yet returned). Use the response to discover tradeable pairs, check minimum order sizes, and read fee schedules. Each entry includes precision settings, fee ratios, and order-size constraints for the market.
     *
     * <Note>
     * Market configuration is reference data, re-synced from the database approximately every 10 seconds. Polling more frequently returns identical data. The cache is shared across all callers.
     * </Note>
     *
     * <Note>
     * TradFi futures markets are coming soon and are not yet returned by this endpoint. Once available, they will be region-gated: markets not available in a given region are omitted from the response entirely and do not appear under any other market type.
     * </Note>
     *
     * <Note>
     * A market with an announced delisting carries the announced date in `delistedAt` and stays tradeable until the delisting runs. Once the delisting runs, the platform cancels the active orders on the market and drops the market from this response — [Query delisting orders](/api-reference/spot-trading/query-delisting-orders) is a signed request that returns the authenticated account's resulting spot order records. An announcement can be rescheduled or canceled, so treat `delistedAt` as the current plan rather than a settled fact and re-read the value on the next poll.
     * </Note>
     *
     * <Warning>
     * Rate limit 2000 requests/10 sec.
     * </Warning>
     *
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<GetApiV4PublicMarketsResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function marketInfo(?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/markets",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [GetApiV4PublicMarketsResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint retrieves a 24-hour pricing and volume summary for each market pair available on the exchange.
     *
     * <Note>
     * The API caches the response for 1 second
     * </Note>
     *
     * <Warning>
     * Rate limit: 2000 requests/10 sec. See [Public API V4 overview](/public/http-v4/index) for rate limit details.
     * </Warning>
     *
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<string, GetApiV4PublicTickerResponseValue>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function marketActivity(?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/ticker",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, ['string' => GetApiV4PublicTickerResponseValue::class]); // @phpstan-ignore-line
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
     * The endpoint retrieves the deposit and withdrawal status for every supported asset. Use the response to check whether deposits and withdrawals are enabled, read per-network fee and limit details, and determine required blockchain confirmation counts. The response includes crypto assets, fiat currencies, and fiat payment methods.
     *
     * <Note>
     * Asset status is reference data, re-synced approximately once per minute. Polling more frequently returns identical data. The cache is shared across all callers.
     * </Note>
     *
     * <Warning>
     * Rate limit: 2000 requests/10 sec. See [Public API V4 overview](/public/http-v4/index) for rate limit details.
     * </Warning>
     *
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<string, Asset>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function assetStatusList(?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/assets",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, ['string' => Asset::class]); // @phpstan-ignore-line
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
     * The endpoint retrieves the current [order book](/glossary#order-book) as two arrays ([bids](/glossary#bid) / [asks](/glossary#ask)) with additional parameters.
     *
     * <Note>
     * The API caches the response for 100 ms
     * </Note>
     *
     * <Warning>
     * Rate limit 600 requests/10 sec.
     * </Warning>
     *
     * @param string $market Market pair name
     * @param GetApiV4PublicOrderbookMarketRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return OrderbookResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function orderbook(string $market, GetApiV4PublicOrderbookMarketRequest $request = new GetApiV4PublicOrderbookMarketRequest(), ?array $options = null): OrderbookResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->limit != null) {
            $query['limit'] = $request->limit;
        }
        if ($request->level != null) {
            $query['level'] = $request->level;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/orderbook/{$market}",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return OrderbookResponse::fromJson($json);
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
     * The endpoint retrieves depth price levels within ±2% of the market last price. Use when lightweight order book data is needed for a narrow price band around the current market price. The ±2% constraint limits the response to price levels near the last traded price, reducing payload size compared to the full order book.
     *
     * <Note>
     * The API caches the response for 1 sec
     * </Note>
     *
     * <Warning>
     * Rate limit: 2000 requests/10 sec. See [Public API V4 overview](/public/http-v4/index) for rate limit details.
     * </Warning>
     *
     * @param string $market Market pair name
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return OrderbookResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function depth(string $market, ?array $options = null): OrderbookResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/orderbook/depth/{$market}",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return OrderbookResponse::fromJson($json);
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
     * The endpoint retrieves the [trades](/glossary#deal-trade) that have been executed recently on the requested [market](/glossary#market). It returns up to the 100 most recent trades; the response size is fixed and there is no `limit` parameter.
     *
     * <Note>
     * The API caches the response for 1 second
     * </Note>
     *
     * <Note>
     *   Public trade data can include executions that originate from RPI orders. Public order book feeds (`depth`, `bookTicker`) exclude RPI orders. RPI orders appear only in private active orders and in the exchange UI order book (web and mobile).
     * </Note>
     *
     *
     * <Warning>
     * Rate limit 2000 requests/10 sec.
     * </Warning>
     *
     * @param string $market Market pair name
     * @param GetApiV4PublicTradesMarketRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<GetApiV4PublicTradesMarketResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function recentTrades(string $market, GetApiV4PublicTradesMarketRequest $request = new GetApiV4PublicTradesMarketRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->type != null) {
            $query['type'] = $request->type;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/trades/{$market}",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [GetApiV4PublicTradesMarketResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint retrieves the [fee](/glossary#fee) schedule and deposit/withdrawal limits for every supported asset. Use the response to display fee estimates before a user initiates a deposit or withdrawal. The response is keyed by currency ticker; each entry contains deposit and withdrawal fee amounts and min/max transfer limits.
     *
     * <Note>
     * The fee schedule is reference data, re-synced approximately once per minute. Polling more frequently returns identical data. The cache is shared across all callers.
     * </Note>
     *
     * <Warning>
     * Rate limit: 2000 requests/10 sec. See [Public API V4 overview](/public/http-v4/index) for rate limit details.
     * </Warning>
     *
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<string, FeeInfo>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function fee(?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/fee",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, ['string' => FeeInfo::class]); // @phpstan-ignore-line
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
     * The endpoint retrieves the current server time as a Unix timestamp. Use the response to synchronize local clocks before generating HMAC signatures for authenticated requests. The endpoint takes no parameters and has no request-validation errors; it returns HTTP 200 on success and fails only at the infrastructure level (see the API description).
     *
     * <Note>
     * The server time is computed per request and is not cached.
     * </Note>
     *
     * <Warning>
     * Rate limit 2000 requests/10 sec.
     * </Warning>
     *
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetApiV4PublicTimeResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function serverTime(?array $options = null): GetApiV4PublicTimeResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/time",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetApiV4PublicTimeResponse::fromJson($json);
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
     * The endpoint checks API availability by returning a simple health-check response. Use the endpoint to verify network connectivity and confirm the API server is reachable. A successful response contains the string `"pong"`. The endpoint takes no parameters and has no request-validation errors; it returns HTTP 200 on success and fails only at the infrastructure level (see the API description).
     *
     * <Note>
     * The health-check response is generated per request and is not cached.
     * </Note>
     *
     * <Warning>
     * Rate limit 2000 requests/10 sec.
     * </Warning>
     *
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<string>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function serverStatus(?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/ping",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, ['string']); // @phpstan-ignore-line
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
     * The endpoint returns the list of [market](/glossary#market) pair names available for [collateral](/glossary#collateral) trading. Use the response to determine which markets support margin positions. Each item in the result array is a market pair name in `BASE_QUOTE` format (e.g., `BTC_USDT`).
     *
     * <Note>
     * The collateral market list is reference data, re-synced approximately every 10 seconds. Polling more frequently returns identical data. The cache is shared across all callers.
     * </Note>
     *
     * <Warning>
     * Rate limit 2000 requests/10 sec.
     * </Warning>
     *
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetApiV4PublicCollateralMarketsResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function collateralMarketsList(?array $options = null): GetApiV4PublicCollateralMarketsResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/collateral/markets",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetApiV4PublicCollateralMarketsResponse::fromJson($json);
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
     * The endpoint returns detailed information for all available futures markets. Use the response to read current pricing, open interest, funding rates, and leverage bracket configuration. Each entry includes the predicted next funding rate, settlement timestamps, and maximum allowed position sizes per leverage level.
     *
     * <Note>
     * The API caches the response for 1 second
     * </Note>
     *
     * <Warning>
     * Rate limit 2000 requests/10 sec.
     * </Warning>
     *
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetApiV4PublicFuturesResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function availableFuturesMarketsList(?array $options = null): GetApiV4PublicFuturesResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/futures",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetApiV4PublicFuturesResponse::fromJson($json);
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
     * The endpoint returns the funding rate history for a specified futures market. Use the response to analyze historical funding rate trends and settlement prices. Results are sorted by funding time in descending order and support offset-based pagination via `limit` and `offset` parameters.
     *
     * <Warning>
     * Rate limit 2000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * This endpoint supports pagination. Use `limit` (default: 100, max: 100) and `offset` (default: 0, max: 1000000) to page through results.
     * </Note>
     *
     * <Note>
     * The response is a plain array with no `total`, `has_more`, or cursor — a returned count below `limit` marks the last page (an empty array means no further records).
     * </Note>
     *
     * <Note>
     * Funding history is served per request at the API layer, with no application-level cache.
     * </Note>
     *
     * @param string $market Market name (e.g., BTC_PERP)
     * @param GetApiV4PublicFundingHistoryMarketRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<GetApiV4PublicFundingHistoryMarketResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function fundingHistory(string $market, GetApiV4PublicFundingHistoryMarketRequest $request = new GetApiV4PublicFundingHistoryMarketRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->startDate != null) {
            $query['startDate'] = $request->startDate;
        }
        if ($request->endDate != null) {
            $query['endDate'] = $request->endDate;
        }
        if ($request->limit != null) {
            $query['limit'] = $request->limit;
        }
        if ($request->offset != null) {
            $query['offset'] = $request->offset;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/funding-history/{$market}",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [GetApiV4PublicFundingHistoryMarketResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint returns overall information about the current mining pool state.
     *
     * Hash rate is expressed in H units.
     *
     * <Warning>
     * Rate limit 1000 requests/10 sec.
     * </Warning>
     *
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetApiV4PublicMiningPoolResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function miningPoolOverview(?array $options = null): GetApiV4PublicMiningPoolResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/public/mining-pool",
                    method: HttpMethod::GET,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetApiV4PublicMiningPoolResponse::fromJson($json);
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
