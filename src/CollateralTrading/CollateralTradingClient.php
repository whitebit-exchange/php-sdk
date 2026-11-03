<?php

namespace Whitebit\CollateralTrading;

use Psr\Http\Client\ClientInterface;
use Whitebit\Core\Client\RawClient;
use Whitebit\Environments;
use Whitebit\CollateralTrading\Requests\CollateralAccountBalanceRequest;
use Whitebit\Exceptions\WhitebitException;
use Whitebit\Exceptions\WhitebitApiException;
use Whitebit\Core\Json\JsonApiRequest;
use Whitebit\Core\Client\HttpMethod;
use Whitebit\Core\Json\JsonDecoder;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Whitebit\CollateralTrading\Requests\CollateralAccountBalanceSummaryRequest;
use Whitebit\CollateralTrading\Types\CollateralAccountBalanceSummaryResponseItem;
use Whitebit\CollateralTrading\Requests\CreateCollateralLimitOrderRequest;
use Whitebit\CollateralTrading\Types\CreateCollateralLimitOrderResponse;
use Whitebit\CollateralTrading\Requests\CreateCollateralBulkOrderRequest;
use Whitebit\CollateralTrading\Types\CreateCollateralBulkOrderResponseItem;
use Whitebit\CollateralTrading\Requests\CreateCollateralMarketOrderRequest;
use Whitebit\CollateralTrading\Types\CreateCollateralMarketOrderResponse;
use Whitebit\CollateralTrading\Requests\CreateCollateralStopLimitOrderRequest;
use Whitebit\CollateralTrading\Types\CreateCollateralStopLimitOrderResponse;
use Whitebit\CollateralTrading\Requests\CreateCollateralTriggerMarketOrderRequest;
use Whitebit\CollateralTrading\Types\CreateCollateralTriggerMarketOrderResponse;
use Whitebit\CollateralTrading\Requests\CollateralAccountSummaryRequest;
use Whitebit\CollateralTrading\Types\CollateralAccountSummaryResponse;
use Whitebit\CollateralTrading\Requests\GetOpenPositionsRequest;
use Whitebit\CollateralTrading\Types\GetOpenPositionsResponseItem;
use Whitebit\CollateralTrading\Requests\ClosePositionRequest;
use Whitebit\CollateralTrading\Requests\GetPositionsHistoryRequest;
use Whitebit\CollateralTrading\Types\GetPositionsHistoryResponseItem;
use Whitebit\CollateralTrading\Requests\GetClosedPositionsPnlRequest;
use Whitebit\CollateralTrading\Types\GetClosedPositionsPnlResponseItem;
use Whitebit\CollateralTrading\Requests\GetFundingHistoryRequest;
use Whitebit\CollateralTrading\Types\GetFundingHistoryResponse;
use Whitebit\CollateralTrading\Requests\ChangeCollateralAccountLeverageRequest;
use Whitebit\CollateralTrading\Types\ChangeCollateralAccountLeverageResponse;
use Whitebit\CollateralTrading\Requests\GetCollateralHedgeModeRequest;
use Whitebit\CollateralTrading\Types\GetCollateralHedgeModeResponse;
use Whitebit\CollateralTrading\Requests\UpdateHedgeModeRequest;
use Whitebit\CollateralTrading\Requests\GetCollateralAccountAdlQuantileRequest;
use Whitebit\CollateralTrading\Types\GetCollateralAccountAdlQuantileResponseItem;
use Whitebit\CollateralTrading\Requests\GetConditionalOrdersRequest;
use Whitebit\CollateralTrading\Types\GetConditionalOrdersResponse;
use Whitebit\CollateralTrading\Requests\GetOcoOrdersRequest;
use Whitebit\CollateralTrading\Types\GetOcoOrdersResponseItem;
use Whitebit\CollateralTrading\Requests\CreateCollateralOcoOrderRequest;
use Whitebit\CollateralTrading\Types\CreateCollateralOcoOrderResponse;
use Whitebit\CollateralTrading\Requests\CancelConditionalOrderRequest;
use Whitebit\CollateralTrading\Requests\CancelOcoOrderRequest;
use Whitebit\CollateralTrading\Types\CancelOcoOrderResponse;
use Whitebit\CollateralTrading\Requests\CancelOtoOrderRequest;

class CollateralTradingClient
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
     * The endpoint returns the current [collateral balance](/glossary#balance-collateral) for one or all assets. The response maps each asset ticker to its collateral balance amount. Use the optional `ticker` parameter to filter results to a single asset.
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "ticker": ["ticker is invalid."]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param CollateralAccountBalanceRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<string, float>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function collateralAccountBalance(CollateralAccountBalanceRequest $request = new CollateralAccountBalanceRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/collateral-account/balance",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, ['string' => 'float']); // @phpstan-ignore-line
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
     * The endpoint returns a detailed [collateral balance](/glossary#balance-collateral) summary with a per-asset breakdown. Each record includes the current balance, borrowed amount, and available balance with and without borrowing capacity. Use the optional `ticker` parameter to filter results to a single asset.
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "ticker": ["ticker is invalid."]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param CollateralAccountBalanceSummaryRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<CollateralAccountBalanceSummaryResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function collateralAccountBalanceSummary(CollateralAccountBalanceSummaryRequest $request = new CollateralAccountBalanceSummaryRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/collateral-account/balance-summary",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [CollateralAccountBalanceSummaryResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint creates a [limit order](/glossary#limit-order) using [collateral balance](/glossary#balance-collateral). The order executes at the specified price or better. Use `buy` to open or increase a long position and `sell` to open or increase a short position. To close a position, place an opposite-side order matching the position amount.
     *
     * **Order validation rules** (per-market, from `GET /api/v4/public/markets`):
     * - `amount` must have at most `stockPrec` decimal places
     * - `price` must have at most `moneyPrec` decimal places
     * - `amount` must be ≥ `minAmount`
     * - `amount × price` must be ≥ `minTotal`
     * - `amount × price` must be ≤ `maxTotal` (when `maxTotal` is not `"0"`)
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * For open long position use **buy**, for short **sell**. To close current position, place opposite order with current position amount.
     * </Note>
     *
     * <Note>
     *   - RPI orders are post-only by design and cannot be used with the IOC flag. The API returns error code `40` when both `rpi=true` and `ioc=true` are used.
     * </Note>
     *
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code. Also returned when `reduceOnly=true` is combined with `stopLoss` or `takeProfit`
     *   - `31` - market validation failed
     *   - `32` - amount validation failed
     *   - `33` - price validation failed
     *   - `36` - clientOrderId validation failed
     *   - `37` - `ioc=true` cannot be combined with `postOnly=true`
     *   - `40` - `ioc=true` cannot be combined with `rpi=true`
     *   - `43` - `rpi=true` is not allowed for the account
     *   - `10` - insufficient balance to place the order
     *   - `111` - resulting position would exceed the market maximum
     *   - `112` - pending orders value would exceed the allowed maximum
     *   - `113` - position side cannot be changed while open positions or orders exist
     *   - `114` - hedge mode position side does not match (sent `BOTH` or omitted `positionSide` in hedge mode, or sent `LONG`/`SHORT` in one-way mode)
     *   - `115` - order would open a position in the opposite direction (one-way mode)
     *   - `116` - reduce-only validation failed (no position exists or order side matches position direction)
     * </Accordion>
     *
     * @param CreateCollateralLimitOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CreateCollateralLimitOrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createCollateralLimitOrder(CreateCollateralLimitOrderRequest $request, ?array $options = null): CreateCollateralLimitOrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/collateral/limit",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CreateCollateralLimitOrderResponse::fromJson($json);
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
     * The endpoint creates multiple collateral [limit orders](/glossary#limit-order) in a single request. Each order in the `orders` array is validated and processed individually. The `stopOnFail` parameter controls whether processing stops at the first failure or continues through all orders. The response array contains a result or error object for each submitted order, in the same order as the request.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code (per-order). Also returned when `reduceOnly=true` is combined with `stopLoss` or `takeProfit`
     *   - `31` - market validation failed
     *   - `32` - amount validation failed
     *   - `33` - price validation failed
     *   - `36` - clientOrderId validation failed
     *   - `37` - `ioc=true` cannot be used with `postOnly=true` or `rpi=true`
     *   - `10` - insufficient balance to place the order
     *   - `111` - resulting position would exceed the market maximum
     *   - `112` - pending orders value would exceed the allowed maximum
     *   - `113` - position side cannot be changed while open positions or orders exist
     *   - `114` - hedge mode position side does not match (per-order; sent `BOTH` or omitted `positionSide` in hedge mode, or sent `LONG`/`SHORT` in one-way mode)
     *   - `115` - order would open a position in the opposite direction (one-way mode)
     *   - `116` - reduce-only validation failed (no position exists or order side matches position direction). For bulk orders, this error appears per-order inside the response array.
     * </Accordion>
     *
     * @param CreateCollateralBulkOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<CreateCollateralBulkOrderResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createCollateralBulkOrder(CreateCollateralBulkOrderRequest $request = new CreateCollateralBulkOrderRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/collateral/bulk",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [CreateCollateralBulkOrderResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint creates a [market order](/glossary#market-order) using [collateral balance](/glossary#balance-collateral). The order executes immediately at the best available market price. Optionally attach `stopLoss` and `takeProfit` prices to create an [OTO](/glossary#one-triggers-the-other-oto) order that activates after the market order fills.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code. Also returned when `reduceOnly=true` is combined with `stopLoss` or `takeProfit`
     *   - `31` - market validation failed
     *   - `32` - amount validation failed
     *   - `36` - clientOrderId validation failed
     *   - `10` - insufficient balance to place the order
     *   - `111` - resulting position would exceed the market maximum
     *   - `112` - pending orders value would exceed the allowed maximum
     *   - `113` - position side cannot be changed while open positions or orders exist
     *   - `114` - hedge mode position side does not match (sent `BOTH` or omitted `positionSide` in hedge mode, or sent `LONG`/`SHORT` in one-way mode)
     *   - `115` - order would open a position in the opposite direction (one-way mode)
     *   - `116` - reduce-only validation failed (no position exists or order side matches position direction)
     * </Accordion>
     *
     * @param CreateCollateralMarketOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CreateCollateralMarketOrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createCollateralMarketOrder(CreateCollateralMarketOrderRequest $request, ?array $options = null): CreateCollateralMarketOrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/collateral/market",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CreateCollateralMarketOrderResponse::fromJson($json);
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
     * The endpoint creates a collateral [stop-limit order](/glossary#stop-limit-order) using [collateral balance](/glossary#balance-collateral). The order remains inactive until the market price reaches `activation_price`, then places a limit order at `price`. Optionally attach `stopLoss` and `takeProfit` prices to create an [OTO](/glossary#one-triggers-the-other-oto) order that activates after the stop-limit order fills.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code. Also returned when `reduceOnly=true` is combined with `stopLoss` or `takeProfit`
     *   - `31` - market validation failed
     *   - `32` - amount validation failed
     *   - `33` - price validation failed
     *   - `36` - clientOrderId validation failed
     *   - `10` - insufficient balance to place the order
     *   - `111` - resulting position would exceed the market maximum
     *   - `112` - pending orders value would exceed the allowed maximum
     *   - `113` - position side cannot be changed while open positions or orders exist
     *   - `114` - hedge mode position side does not match (sent `BOTH` or omitted `positionSide` in hedge mode, or sent `LONG`/`SHORT` in one-way mode)
     *   - `115` - order would open a position in the opposite direction (one-way mode)
     *   - `116` - reduce-only validation failed (no position exists or order side matches position direction)
     * </Accordion>
     *
     * @param CreateCollateralStopLimitOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CreateCollateralStopLimitOrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createCollateralStopLimitOrder(CreateCollateralStopLimitOrderRequest $request, ?array $options = null): CreateCollateralStopLimitOrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/collateral/stop-limit",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CreateCollateralStopLimitOrderResponse::fromJson($json);
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
     * The endpoint creates a collateral trigger [market order](/glossary#market-order) using [collateral balance](/glossary#balance-collateral). The order remains inactive until the market price reaches `activation_price`, then executes immediately at the best available market price. Optionally attach `stopLoss` and `takeProfit` prices to create an [OTO](/glossary#one-triggers-the-other-oto) order that activates after the trigger market order fills.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code. Also returned when `reduceOnly=true` is combined with `stopLoss` or `takeProfit`
     *   - `31` - market validation failed
     *   - `32` - amount validation failed
     *   - `36` - clientOrderId validation failed
     *   - `10` - insufficient balance to place the order
     *   - `111` - resulting position would exceed the market maximum
     *   - `112` - pending orders value would exceed the allowed maximum
     *   - `113` - position side cannot be changed while open positions or orders exist
     *   - `114` - hedge mode position side does not match (sent `BOTH` or omitted `positionSide` in hedge mode, or sent `LONG`/`SHORT` in one-way mode)
     *   - `115` - order would open a position in the opposite direction (one-way mode)
     *   - `116` - reduce-only validation failed (no position exists or order side matches position direction)
     * </Accordion>
     *
     * @param CreateCollateralTriggerMarketOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CreateCollateralTriggerMarketOrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createCollateralTriggerMarketOrder(CreateCollateralTriggerMarketOrderRequest $request, ?array $options = null): CreateCollateralTriggerMarketOrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/collateral/trigger-market",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CreateCollateralTriggerMarketOrderResponse::fromJson($json);
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
     * The endpoint returns a collateral account summary including total equity, used margin, free margin, unrealized profit and loss, and the current leverage level. The `marginFraction` field indicates the ratio of used margin to total equity.
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * @param CollateralAccountSummaryRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CollateralAccountSummaryResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function collateralAccountSummary(CollateralAccountSummaryRequest $request = new CollateralAccountSummaryRequest(), ?array $options = null): CollateralAccountSummaryResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/collateral-account/summary",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CollateralAccountSummaryResponse::fromJson($json);
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
     * The endpoint returns all open [collateral](/glossary#balance-collateral) positions for the authenticated account. Each position includes entry price, unrealized PnL, margin allocation, liquidation price, and take-profit/stop-loss configuration. Use the optional `market` parameter to filter results to a single trading pair.
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code (returned when the optional `market` filter is malformed)
     * </Accordion>
     *
     * @param GetOpenPositionsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<GetOpenPositionsResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getOpenPositions(GetOpenPositionsRequest $request = new GetOpenPositionsRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/collateral-account/positions/open",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [GetOpenPositionsResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint closes an open [collateral](/glossary#balance-collateral) position at the current market price. The system places a market order in the opposite direction to fully close the specified position. Any attached take-profit or stop-loss orders are cancelled automatically.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code (for example, a missing or malformed `positionId` or `market`)
     *   - `104` - position not found. Returned whether the `positionId` does not exist, the position is already closed, or it is not owned by the account — these cases are not distinguished
     *   - `10` - insufficient balance to fund the closing market order
     * </Accordion>
     *
     * @param ClosePositionRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function closePosition(ClosePositionRequest $request, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/collateral-account/position/close",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                return;
            }
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
     * The endpoint returns the history of [collateral](/glossary#balance-collateral) position state changes for the authenticated account. Each record represents a position event (open, partial close, full close, or liquidation) and includes the order details that triggered the change. Use the optional `market` and `positionId` parameters to filter results.
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code (invalid pagination — `limit` outside 1–100 or negative `offset` — or a date filter that violates `startDate` ≤ `endDate` ≤ `now + 1s`)
     * </Accordion>
     *
     * <Note>
     * **Date filter window:** `startDate` and `endDate` are optional and have no defaults. The endpoint enforces no maximum window and no lower-bound floor. The only ordering constraint is `startDate` ≤ `endDate` ≤ `now + 1s` — requests that violate the ordering are rejected with a validation error.
     * </Note>
     *
     * <Warning>
     * **Breaking change — April 29, 2026.** The `positionSide` field is no longer returned in the Position History response. Use `side` (same enum: `LONG`, `SHORT`, `BOTH`) plus `isHedge` (boolean) instead. Integrations reading `positionSide` from `/api/v4/collateral-account/positions/history` must migrate before consuming the new response.
     * </Warning>
     *
     * @param GetPositionsHistoryRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<GetPositionsHistoryResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getPositionsHistory(GetPositionsHistoryRequest $request = new GetPositionsHistoryRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/collateral-account/positions/history",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [GetPositionsHistoryResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint returns one aggregated profit-and-loss record per closed [collateral](/glossary#balance-collateral) position for the authenticated account — the same closed-position PNL the trading terminal shows. Records are sorted by `closeDate` descending, then `positionId` descending. Use the optional `startDate` and `endDate` parameters to narrow the window; the filter applies to the position close time.
     *
     * <Note>
     * The endpoint supports pagination via `limit` (default: 50, max: 100) and `offset` (default: 0); the sum of `offset` and `limit` must not exceed 10000. A response that returns fewer than `limit` records indicates the last page.
     * </Note>
     *
     * <Note>
     * **Close-time windowing:** a position opened before the requested window but closed inside the window returns complete aggregates — fees, average prices, and closed size cover the full position lifetime, not only the requested window.
     * </Note>
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code (invalid pagination — `limit` outside 1–100, or `offset` + `limit` above 10000 — or a date filter that violates `startDate` ≤ `endDate` ≤ `now + 1s`)
     * </Accordion>
     *
     * @param GetClosedPositionsPnlRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<GetClosedPositionsPnlResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getClosedPositionsPnl(GetClosedPositionsPnlRequest $request = new GetClosedPositionsPnlRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/collateral-account/positions/closed-pnl",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [GetClosedPositionsPnlResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint returns the funding rate payment history for [collateral](/glossary#balance-collateral) positions. Each record includes the funding rate, settlement price, position amount, and the resulting funding payment. Use the optional `market` parameter to filter results to a single trading pair. The response supports pagination via `limit` and `offset` parameters. Results are ordered by funding time (`fundingTime`), newest first.
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * This endpoint supports pagination. Use `limit` (default: 100) and `offset` (default: 0) to page through results. The response does not include a `total` field — detect the last page when `records.length < limit`. An empty `records` array means you have paged past the end; receiving exactly `limit` records does not guarantee that another page exists.
     * </Note>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code (invalid pagination — `limit` outside 1–100 or negative `offset`)
     *   - `31` - market validation failed (the `market` filter is unknown or not available for collateral trading)
     * </Accordion>
     *
     * @param GetFundingHistoryRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetFundingHistoryResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getFundingHistory(GetFundingHistoryRequest $request = new GetFundingHistoryRequest(), ?array $options = null): GetFundingHistoryResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/collateral-account/funding-history",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetFundingHistoryResponse::fromJson($json);
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
     * The endpoint changes the leverage level for the [collateral](/glossary#balance-collateral) trading account. Leverage determines the ratio of borrowed funds to collateral and directly affects margin requirements and liquidation thresholds. Accepted values: `1`, `2`, `3`, `5`, `10`, `20`, `50`, `100`.
     *
     * Each leverage level has a corresponding bracket defining the maximum position size for the tier. When a position exceeds the bracket limit, the system applies higher tiers with progressively lower leverage. Query market-specific brackets via `GET /api/v4/public/futures`.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * A market's `max_leverage` field (from `GET /api/v4/public/futures`) may be lower than `100`. Setting leverage above a market's maximum results in an error.
     * </Note>
     *
     * <Warning>
     * Changing leverage affects **all open positions** across margin and futures trading. Decreasing leverage increases margin requirements — if available funds are insufficient to support the new level, the request returns an error.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - invalid `leverage` value (out of range, non-integer, or wrong type). Setting leverage above a market's `max_leverage` also surfaces here as an out-of-range value
     *   - `17` - the requested leverage is valid but available balance is insufficient to support it
     *   - `113` - leverage cannot be changed while open positions or orders exist
     * </Accordion>
     *
     * @param ChangeCollateralAccountLeverageRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ChangeCollateralAccountLeverageResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function changeCollateralAccountLeverage(ChangeCollateralAccountLeverageRequest $request, ?array $options = null): ChangeCollateralAccountLeverageResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/collateral-account/leverage",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ChangeCollateralAccountLeverageResponse::fromJson($json);
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
     * The endpoint returns the current [hedge mode](/glossary#hedge-mode) status for the collateral trading account. When hedge mode is enabled (`true`), the account supports simultaneous long and short positions on the same market. When disabled (`false`), the account operates in one-way mode.
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * @param GetCollateralHedgeModeRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetCollateralHedgeModeResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getCollateralHedgeMode(GetCollateralHedgeModeRequest $request = new GetCollateralHedgeModeRequest(), ?array $options = null): GetCollateralHedgeModeResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/collateral-account/hedge-mode",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetCollateralHedgeModeResponse::fromJson($json);
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
     * The endpoint enables or disables [hedge mode](/glossary#hedge-mode) for the collateral trading account. When hedge mode is enabled (`true`), the account supports simultaneous long and short positions on the same market. When disabled (`false`), the account operates in one-way mode.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Warning>
     * Switching between one-way mode and hedge mode requires **no open positions**. Close all futures positions before toggling the mode. If the switch does not take effect immediately after closing positions, wait approximately 15 seconds and retry.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code (for example, a missing or non-boolean `hedgeMode` value)
     *   - `113` - hedge mode cannot be changed while open positions or orders exist
     * </Accordion>
     *
     * @param UpdateHedgeModeRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function updateHedgeMode(UpdateHedgeModeRequest $request, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/collateral-account/hedge-mode/update",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                return;
            }
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
     * The endpoint returns the [Auto-Deleveraging (ADL)](/glossary#auto-deleveraging-adl) quantile for each perpetual market in which the authenticated account holds an open position. Each entry exposes the deleveraging-priority value for the long and short sides of the position, where `0` indicates the lowest deleveraging priority and `4` indicates the highest. The endpoint returns an empty array when the account has no perpetual positions.
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * Only perpetual markets (markets with the `_PERP` suffix) are returned. Spot and margin markets are not included.
     * </Note>
     *
     * @param GetCollateralAccountAdlQuantileRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<GetCollateralAccountAdlQuantileResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getCollateralAccountAdlQuantile(GetCollateralAccountAdlQuantileRequest $request, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/collateral-account/adl-quantile",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [GetCollateralAccountAdlQuantileResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint returns active (unexecuted) conditional orders for the authenticated account. Conditional orders include [OCO](/glossary#one-cancels-the-other-oco) and [OTO](/glossary#one-triggers-the-other-oto) types. The response uses polymorphic structure — each record contains a `type` field (`oco` or `oto`) that determines the record shape. Use the optional `market` parameter to filter results.
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code (invalid pagination — `limit` outside 1–100 or negative `offset`)
     *   - `31` - market validation failed (the `market` filter is unknown or not available for collateral trading)
     * </Accordion>
     *
     * @param GetConditionalOrdersRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetConditionalOrdersResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getConditionalOrders(GetConditionalOrdersRequest $request = new GetConditionalOrdersRequest(), ?array $options = null): GetConditionalOrdersResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/conditional-orders",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetConditionalOrdersResponse::fromJson($json);
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
     * The endpoint returns active (unexecuted) [OCO](/glossary#one-cancels-the-other-oco) orders for the authenticated account. Each OCO order contains a `stop_loss` and `take_profit` leg. When one leg executes, the system cancels the other automatically. Use the optional `market` parameter to filter results.
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * This endpoint supports pagination. Use `limit` (default: 50) and `offset` (default: 0) to page through results. The response does not include a `total` field — detect the last page when fewer than `limit` OCO orders are returned. An empty array means you have paged past the end; receiving exactly `limit` orders does not guarantee that another page exists.
     * </Note>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code (invalid pagination — `limit` outside 1–100 or negative `offset`)
     *   - `31` - market validation failed (the `market` filter is unknown or not available for collateral trading)
     * </Accordion>
     *
     * @param GetOcoOrdersRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<GetOcoOrdersResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getOcoOrders(GetOcoOrdersRequest $request = new GetOcoOrdersRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/oco-orders",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [GetOcoOrdersResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint creates a collateral [OCO](/glossary#one-cancels-the-other-oco) (one-cancels-the-other) order using [collateral balance](/glossary#balance-collateral). An OCO order combines a limit order (take-profit leg) and a stop-limit order (stop-loss leg) into a single conditional group. When one leg executes, the system cancels the other automatically.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code. Also returned when `reduceOnly=true` is combined with `stopLoss` or `takeProfit`
     *   - `31` - market validation failed
     *   - `32` - amount validation failed
     *   - `33` - price validation failed
     *   - `36` - clientOrderId validation failed
     *   - `10` - insufficient balance to place the order
     *   - `111` - resulting position would exceed the market maximum
     *   - `112` - pending orders value would exceed the allowed maximum
     *   - `113` - position side cannot be changed while open positions or orders exist
     *   - `114` - hedge mode position side does not match (sent `BOTH` or omitted `positionSide` in hedge mode, or sent `LONG`/`SHORT` in one-way mode)
     *   - `115` - order would open a position in the opposite direction (one-way mode)
     *   - `116` - reduce-only validation failed (no position exists or order side matches position direction)
     * </Accordion>
     *
     * @param CreateCollateralOcoOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CreateCollateralOcoOrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createCollateralOcoOrder(CreateCollateralOcoOrderRequest $request, ?array $options = null): CreateCollateralOcoOrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/collateral/oco",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CreateCollateralOcoOrderResponse::fromJson($json);
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
     * The endpoint cancels an active conditional order ([OCO](/glossary#one-cancels-the-other-oco) or [OTO](/glossary#one-triggers-the-other-oto)) on the specified market. Both legs of the conditional order are cancelled. Use the [query unexecuted conditional orders](/api-reference/collateral-trading/query-unexecuted-conditional-orders) endpoint to obtain the conditional order `id` before cancellation.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code
     *   - `31` - market validation failed
     *   - `2` - conditional order not found. Returned whether the `id` does not exist, or the order was already filled or already cancelled — these cases are not distinguished
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 2,
     *   "message": "Inner validation failed",
     *   "errors": {
     *     "id": ["Unexecuted order was not found."]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param CancelConditionalOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<mixed>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function cancelConditionalOrder(CancelConditionalOrderRequest $request, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/conditional-cancel",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, ['mixed']);
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
     * The endpoint cancels an OCO order. Identify the order by `orderId` or `clientOrderId` — exactly one of the two must be provided. A request specifying both identifiers, or neither, fails validation.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code. Also returned when the request specifies both `orderId` and `clientOrderId`, or neither
     *   - `31` - market validation failed
     *   - `2` - OCO order not found. Returned whether the identifier (`orderId` or `clientOrderId`) does not exist, or the order was already filled or already cancelled — these cases are not distinguished
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 2,
     *   "message": "Inner validation failed",
     *   "errors": {
     *     "orderId": ["Unexecuted order was not found."]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param CancelOcoOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CancelOcoOrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function cancelOcoOrder(CancelOcoOrderRequest $request, ?array $options = null): CancelOcoOrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/oco-cancel",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CancelOcoOrderResponse::fromJson($json);
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
     * The endpoint cancels an OTO order.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code
     *   - `31` - market validation failed
     *   - `2` - OTO order not found. Returned whether the `otoId` does not exist, or the order was already filled or already cancelled — these cases are not distinguished
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 2,
     *   "message": "Inner validation failed",
     *   "errors": {
     *     "otoId": ["Unexecuted order was not found."]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param CancelOtoOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<mixed>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function cancelOtoOrder(CancelOtoOrderRequest $request, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/oto-cancel",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, ['mixed']);
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
