<?php

namespace Whitebit\SpotTrading;

use Psr\Http\Client\ClientInterface;
use Whitebit\Core\Client\RawClient;
use Whitebit\Environments;
use Whitebit\SpotTrading\Requests\TradeAccountBalanceRequest;
use Whitebit\SpotTrading\Types\TradeAccountBalanceResponseValue;
use Whitebit\Exceptions\WhitebitException;
use Whitebit\Exceptions\WhitebitApiException;
use Whitebit\Core\Json\JsonApiRequest;
use Whitebit\Core\Client\HttpMethod;
use Whitebit\Core\Json\JsonDecoder;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Whitebit\SpotTrading\Requests\LimitOrderRequest;
use Whitebit\Types\OrderResponse;
use Whitebit\SpotTrading\Requests\CreateBulkLimitOrderRequest;
use Whitebit\Types\BulkLimitOrderResponseItem;
use Whitebit\SpotTrading\Requests\MarketOrderRequest;
use Whitebit\SpotTrading\Requests\StockMarketOrderRequest;
use Whitebit\SpotTrading\Requests\StopLimitOrderRequest;
use Whitebit\SpotTrading\Requests\StopMarketOrderRequest;
use Whitebit\SpotTrading\Requests\CancelOrderRequest;
use Whitebit\SpotTrading\Requests\CancelBulkOrdersRequest;
use Whitebit\Types\BulkCancelOrderResponseItem;
use Whitebit\SpotTrading\Requests\CancelAllOrdersRequest;
use Whitebit\SpotTrading\Requests\GetActiveOrdersRequest;
use Whitebit\SpotTrading\Requests\GetExecutedOrderHistoryRequest;
use Whitebit\Types\ExecutedDeal;
use Whitebit\Core\Types\Union;
use Whitebit\SpotTrading\Requests\GetOrderDealsRequest;
use Whitebit\SpotTrading\Types\GetOrderDealsResponse;
use Whitebit\SpotTrading\Requests\GetOrderHistoryRequest;
use Whitebit\SpotTrading\Types\GetOrderHistoryResponseValueItem;
use Whitebit\SpotTrading\Requests\GetDelistingOrderHistoryRequest;
use Whitebit\SpotTrading\Types\GetDelistingOrderHistoryResponseItem;
use Whitebit\SpotTrading\Requests\ModifyOrderRequest;
use Whitebit\SpotTrading\Requests\SetKillSwitchRequest;
use Whitebit\SpotTrading\Types\SetKillSwitchResponseCancellationTime;
use Whitebit\SpotTrading\Requests\GetKillSwitchStatusRequest;
use Whitebit\SpotTrading\Types\GetKillSwitchStatusResponseItem;

class SpotTradingClient
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
     * The endpoint retrieves the [trade balance](/glossary#balance-spotbalance-trade) by currency [ticker](/glossary#ticker) or all balances. When the `ticker` parameter is provided, the response contains a single currency entry. When omitted, the response contains all currencies with non-zero balances. Each entry includes the `available` balance (funds ready to trade) and the `freeze` balance (funds locked in open orders).
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
     *     "ticker": ["Ticker field should be a string."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "ticker": ["Currency was not found."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 1,
     *   "message": "Inner validation failed",
     *   "errors": {
     *     "amount": ["Invalid argument."]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param TradeAccountBalanceRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<string, TradeAccountBalanceResponseValue>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function tradeAccountBalance(TradeAccountBalanceRequest $request = new TradeAccountBalanceRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/trade-account/balance",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, ['string' => TradeAccountBalanceResponseValue::class]); // @phpstan-ignore-line
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
     * The endpoint creates a [limit trading order](/glossary#limit-order). The order remains on the order book until filled, cancelled, or expired. Minimum and maximum values for `amount` and `price` are market-dependent — query `GET /api/v4/public/markets` for per-market constraints.
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
     *   - RPI orders do not appear in public order book feeds (`depth`, `bookTicker`). RPI orders are visible only in private active orders and in the exchange UI order book (web/mobile).
     *   - RPI orders are post-only by design and cannot be used with the IOC flag. The API returns error code `40` when both `rpi=true` and `ioc=true` are used.
     *   - RPI orders apply post-only behavior automatically — do not also send `postOnly=true`: a request combining `rpi=true` with an explicit `postOnly=true` fails validation.
     *   - `retail=true` marks the order as a retail-source taker eligible to match RPI-maker liquidity. The Retail flag must be enabled on the account; contact the account manager to enable it.
     *   - `retail=true` and `rpi=true` cannot be combined. The API returns error code `41` when both flags are set.
     *   - `retail=true` has no effect on a `postOnly=true` order. Post-only orders are makers and cannot be retail takers.
     * </Note>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code
     *   - `31` - market validation failed
     *   - `32` - amount validation failed
     *   - `33` - price validation failed
     *   - `36` - clientOrderId validation failed
     *   - `37` - `ioc=true` cannot be combined with `postOnly=true`
     *   - `40` - `ioc=true` cannot be combined with `rpi=true`
     *   - `41` - `retail=true` cannot be combined with `rpi=true`
     *   - `42` - `retail=true` is not allowed for the account
     *   - `43` - `rpi=true` is not allowed for the account
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount field is required."],
     *     "market": ["Market field is required."],
     *     "price": ["Price field is required."],
     *     "side": ["Side field is required."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "side": ["Side field should contain only 'buy' or 'sell' values."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount field should be numeric string or number."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 33,
     *   "message": "Validation failed",
     *   "errors": {
     *     "price": ["Price field should be numeric string or number."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market is not available."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market field should not be empty string."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": [
     *       "Given amount is less than min amount 0.001",
     *       "Min amount step = 0.000001"
     *     ]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 36,
     *   "message": "Validation failed",
     *   "errors": {
     *     "clientOrderId": ["ClientOrderId field should be a string."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 36,
     *   "message": "Validation failed",
     *   "errors": {
     *     "clientOrderId": [
     *       "ClientOrderId field should contain only latin letters, numbers and dashes."
     *     ]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 36,
     *   "message": "Validation failed",
     *   "errors": {
     *     "clientOrderId": [
     *       "This client order id is already used by the current account."
     *     ]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 37,
     *   "message": "Validation failed",
     *   "errors": {
     *     "ioc": ["Either IOC or PostOnly flag in true state is allowed."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "total": ["Total (amount * price) is less than 5.05"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": [
     *       "Min amount step = 0.01"
     *     ]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 33,
     *   "message": "Validation failed",
     *   "errors": {
     *     "price": ["Price field should be at least 10", "Min price step = 0.000001"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 33,
     *   "message": "Validation failed",
     *   "errors": {
     *     "price": ["Price should be greater than 0."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 35,
     *   "message": "Validation failed",
     *   "errors": {
     *     "maker_fee": ["Incorrect maker fee"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 41,
     *   "message": "Validation failed",
     *   "errors": {
     *     "retail": ["api.tradeErrors.flagsCantBeCombined.rpiRetail"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 42,
     *   "message": "Validation failed",
     *   "errors": {
     *     "retail": ["api.validation.retail.not_allowed"]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param LimitOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return OrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createLimitOrder(LimitOrderRequest $request, ?array $options = null): OrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/new",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return OrderResponse::fromJson($json);
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
     * The endpoint creates bulk [limit trading orders](/glossary#limit-order). Each order in the batch follows the same validation rules as a single limit order. The `stopOnFail` parameter controls whether processing stops at the first failure or continues through all orders. The response contains a result-or-error pair for each submitted order.
     *
     * <Warning>
     *   Limit: From 1 to 20 orders per request.
     * </Warning>
     *
     * <Note>
     *   - RPI orders do not appear in public order book feeds (`depth`, `bookTicker`). RPI orders are visible only in private active orders and in the exchange UI order book (web/mobile).
     *   - RPI orders are post-only by design and cannot be used with the IOC flag. The API returns error code `40` when both `rpi=true` and `ioc=true` are used.
     *   - RPI orders apply post-only behavior automatically — do not also send `postOnly=true`: a request combining `rpi=true` with an explicit `postOnly=true` fails validation.
     *   - `retail=true` marks the order as a retail-source taker eligible to match RPI-maker liquidity. The Retail flag must be enabled on the account; contact the account manager to enable it.
     *   - `retail=true` and `rpi=true` cannot be combined. The API returns error code `41` when both flags are set on an item.
     *   - `retail=true` has no effect on a `postOnly=true` item. Post-only orders are makers and cannot be retail takers.
     * </Note>
     *
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code
     *   - `31` - market validation failed
     *   - `32` - amount validation failed
     *   - `33` - price validation failed
     *   - `36` - clientOrderId validation failed
     *   - `37` - `ioc=true` cannot be combined with `postOnly=true`
     *   - `40` - `ioc=true` cannot be combined with `rpi=true`
     *   - `41` - `retail=true` cannot be combined with `rpi=true`
     *   - `42` - `retail=true` is not allowed for the account
     *   - `43` - `rpi=true` is not allowed for the account
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "orders": ["The orders must be an array."]
     *   }
     * }
     * ```
     *
     * Individual order errors (in multiply response):
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount field is required."],
     *     "market": ["Market field is required."],
     *     "price": ["Price field is required."],
     *     "side": ["Side field is required."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "side": ["Side field should contain only 'buy' or 'sell' values."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount field should be numeric string or number."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 33,
     *   "message": "Validation failed",
     *   "errors": {
     *     "price": ["Price field should be numeric string or number."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 41,
     *   "message": "Validation failed",
     *   "errors": {
     *     "retail": ["api.tradeErrors.flagsCantBeCombined.rpiRetail"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 42,
     *   "message": "Validation failed",
     *   "errors": {
     *     "retail": ["api.validation.retail.not_allowed"]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param CreateBulkLimitOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<BulkLimitOrderResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createBulkLimitOrder(CreateBulkLimitOrderRequest $request, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/bulk",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [BulkLimitOrderResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint creates a [market trading order](/glossary#market-order). The matching engine executes the order immediately at the best available price. For buy orders, `amount` represents the total in quote (money) currency to spend. For sell orders, `amount` represents the quantity in base (stock) currency to sell. Minimum and maximum values are market-dependent. Query `GET /api/v4/public/markets` for `minAmount`, `minTotal`, and `maxTotal`.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     * - `30` - default validation error code
     * - `31` - market validation failed
     * - `32` - amount validation failed
     * - `36` - clientOrderId validation failed
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount field is required."],
     *     "market": ["Market field is required."],
     *     "side": ["Side field is required."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "side": ["Side field should contain only 'buy' or 'sell' values."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount field should be numeric string or number."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market is not available."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market field should not be empty string."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Not enough balance."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": [
     *       "Given amount is less than min amount 0.001",
     *       "Min amount step = 0.000001"
     *     ]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 36,
     *   "message": "Validation failed",
     *   "errors": {
     *     "clientOrderId": ["ClientOrderId field should be a string."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 36,
     *   "message": "Validation failed",
     *   "errors": {
     *     "clientOrderId": [
     *       "ClientOrderId field should contain only latin letters, numbers and dashes."
     *     ]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param MarketOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return OrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createMarketOrder(MarketOrderRequest $request, ?array $options = null): OrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/market",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return OrderResponse::fromJson($json);
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
     * The endpoint creates a [stock](/glossary#stock) market trading [order](/glossary#orders). Unlike `POST /api/v4/order/market`, the `amount` parameter always represents the quantity in the base (stock) currency for both buy and sell sides. The matching engine executes the order immediately at the best available price. Minimum and maximum values are market-dependent. Query `GET /api/v4/public/markets` for `minAmount`, `minTotal`, and `maxTotal`.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     * - `30` - default validation error code
     * - `31` - market validation failed
     * - `32` - amount validation failed
     * - `36` - clientOrderId validation failed
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount field is required."],
     *     "market": ["Market field is required."],
     *     "side": ["Side field is required."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "side": ["Side field should contain only 'buy' or 'sell' values."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount field should be numeric string or number."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market is not available."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market field should not be empty string."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Not enough balance."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": [
     *       "Given amount is less than min amount 0.001",
     *       "Min amount step = 0.000001"
     *     ]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 36,
     *   "message": "Validation failed",
     *   "errors": {
     *     "clientOrderId": ["ClientOrderId field should be a string."]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param StockMarketOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return OrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createStockMarketOrder(StockMarketOrderRequest $request, ?array $options = null): OrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/stock_market",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return OrderResponse::fromJson($json);
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
     * The endpoint creates a [stop-limit trading order](/glossary#stop-limit-order). The order remains inactive until the market price reaches the `activation_price`, at which point the system places a limit order at the specified `price`. For buy orders, activation triggers when the market price rises to or above `activation_price`. For sell orders, activation triggers when the market price falls to or below `activation_price`. Minimum and maximum values for `amount`, `price`, and `activation_price` are market-dependent. Query `GET /api/v4/public/markets` for `minAmount`, `minTotal`, `maxTotal`, `stockPrec` (amount precision), and `moneyPrec` (price precision).
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     * - `30` - default validation error code
     * - `31` - market validation failed
     * - `32` - amount validation failed
     * - `33` - price validation failed
     * - `36` - clientOrderId validation failed
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "activation_price": ["Activation price field is required."],
     *     "amount": ["Amount field is required."],
     *     "market": ["Market field is required."],
     *     "price": ["Price field is required."],
     *     "side": ["Side field is required."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "side": ["Side field should contain only 'buy' or 'sell' values."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount field should be numeric string or number."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 33,
     *   "message": "Validation failed",
     *   "errors": {
     *     "price": ["Price field should be numeric string or number."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market is not available."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market field should not be empty string."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Not enough balance."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": [
     *       "Given amount is less than min amount 0.001",
     *       "Min amount step = 0.000001"
     *     ]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "total": ["Total (amount * price) is less than 5.05"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 36,
     *   "message": "Validation failed",
     *   "errors": {
     *     "clientOrderId": ["ClientOrderId field should be a string."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 36,
     *   "message": "Validation failed",
     *   "errors": {
     *     "clientOrderId": [
     *       "ClientOrderId field should contain only latin letters, numbers and dashes."
     *     ]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param StopLimitOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return OrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createStopLimitOrder(StopLimitOrderRequest $request, ?array $options = null): OrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/stop_limit",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return OrderResponse::fromJson($json);
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
     * The endpoint creates a [stop-market trading order](/glossary#stop-market-order). The order remains inactive until the market price reaches the `activation_price`, at which point the system executes a market order immediately at the best available price. For buy orders, `amount` represents the total in quote currency and activation triggers when the market price rises to or above `activation_price`. For sell orders, `amount` represents the quantity in base currency and activation triggers when the market price falls to or below `activation_price`. Minimum and maximum values are market-dependent. Query `GET /api/v4/public/markets` for `minAmount`, `minTotal`, and `maxTotal`.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     * - `30` - default validation error code
     * - `31` - market validation failed
     * - `32` - amount validation failed
     * - `36` - clientOrderId validation failed
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "activation_price": ["Activation price field is required."],
     *     "amount": ["Amount field is required."],
     *     "market": ["Market field is required."],
     *     "side": ["Side field is required."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "side": ["Side field should contain only 'buy' or 'sell' values."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount field should be numeric string or number."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market is not available."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market field should not be empty string."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Not enough balance."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": [
     *       "Given amount is less than min amount 0.001",
     *       "Min amount step = 0.000001"
     *     ]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 36,
     *   "message": "Validation failed",
     *   "errors": {
     *     "clientOrderId": ["ClientOrderId field should be a string."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 36,
     *   "message": "Validation failed",
     *   "errors": {
     *     "clientOrderId": [
     *       "ClientOrderId field should contain only latin letters, numbers and dashes."
     *     ]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 36,
     *   "message": "Validation failed",
     *   "errors": {
     *     "clientOrderId": [
     *       "This client order id is already used by the current account."
     *     ]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 32,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount should be greater than 0."]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param StopMarketOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return OrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createStopMarketOrder(StopMarketOrderRequest $request, ?array $options = null): OrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/stop_market",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return OrderResponse::fromJson($json);
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
     * The endpoint cancels an existing [order](/glossary#orders). Provide either `orderId` or `clientOrderId` to identify the target order. The response returns the final state of the cancelled order.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * - The request accepts exactly one identifier: either `orderId` or `clientOrderId`.
     * - Sending both identifiers, or neither, returns a validation error.
     * </Note>
     *
     * <Accordion title="Error Codes">
     * - `30` - default validation error code
     * - `31` - market validation failed
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market field is required."],
     *     "orderId": ["OrderId field is required."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market is not available."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market is not available."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "orderId": ["OrderId field should be an integer."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": [
     *       "Market field should be a string.",
     *       "Market field format is invalid."
     *     ]
     *   }
     * }
     * ```
     *
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
     * @param CancelOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return OrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function cancelOrder(CancelOrderRequest $request, ?array $options = null): OrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/cancel",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return OrderResponse::fromJson($json);
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
     * The endpoint cancels up to 100 [orders](/glossary#orders) in a single request. Each item identifies a target order by `market` plus exactly one of `orderId` or `clientOrderId`. The response is an array whose items match the input order one-to-one — `response[i]` corresponds to `request.orders[i]`.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Warning>
     * Limit: From 1 to 100 orders per request.
     * </Warning>
     *
     * <Note>
     * - Provide exactly one of `orderId` or `clientOrderId` per item. Sending both, or neither, returns a per-item validation error.
     * - The endpoint always processes every item independently. There is no `stopOnFail`-style switch.
     * - When the caller is not authenticated, the API returns the standard authorization error and skips per-item validation.
     * </Note>
     *
     * <Accordion title="Error Codes">
     * - `30` — validation failure (per-item)
     * - `404` — order not found (per-item)
     * - `500` — trade service unavailable (per-item)
     * </Accordion>
     *
     * <Accordion title="Errors">
     * **Per-item errors (returned inside the response array):**
     *
     * Element is not a valid object:
     * ```json
     * {
     *   "result": null,
     *   "error": {
     *     "code": 30,
     *     "message": "Validation failed",
     *     "errors": { "request": ["Invalid order format"] }
     *   }
     * }
     * ```
     *
     * `market` field is missing:
     * ```json
     * {
     *   "result": null,
     *   "error": {
     *     "code": 30,
     *     "message": "Validation failed",
     *     "errors": { "market": ["validation.required"] }
     *   }
     * }
     * ```
     *
     * Specified market does not exist:
     * ```json
     * {
     *   "result": null,
     *   "error": {
     *     "code": 30,
     *     "message": "Validation failed",
     *     "errors": { "market": ["validation.market_not_exist"] }
     *   }
     * }
     * ```
     *
     * Neither `orderId` nor `clientOrderId` provided:
     * ```json
     * {
     *   "result": null,
     *   "error": {
     *     "code": 30,
     *     "message": "Validation failed",
     *     "errors": { "request": ["validation.required"] }
     *   }
     * }
     * ```
     *
     * Both `orderId` and `clientOrderId` provided:
     * ```json
     * {
     *   "result": null,
     *   "error": {
     *     "code": 30,
     *     "message": "Validation failed",
     *     "errors": { "request": ["api.validation.order.chooseOneId"] }
     *   }
     * }
     * ```
     *
     * Order not found (returned for both `orderId` and `clientOrderId` lookups):
     * ```json
     * {
     *   "result": null,
     *   "error": {
     *     "code": 404,
     *     "message": "Order not found",
     *     "errors": {
     *       "orderId": ["Order does not exist or already cancelled"]
     *     }
     *   }
     * }
     * ```
     *
     * Trade service unavailable (returned when the trade service is unreachable or returns an unparseable response):
     * ```json
     * {
     *   "result": null,
     *   "error": {
     *     "code": 500,
     *     "message": "Service temporary unavailable",
     *     "errors": { "error": ["Service temporary unavailable"] }
     *   }
     * }
     * ```
     *
     * **Request-level errors (HTTP 422, returned as a standard error envelope, not as an array):**
     *
     * `orders` field is missing or is not an array:
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": { "orders": ["validation.required"] }
     * }
     * ```
     *
     * `orders` contains more than 100 elements:
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": { "orders": ["validation.between"] }
     * }
     * ```
     * </Accordion>
     *
     * @param CancelBulkOrdersRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<BulkCancelOrderResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function cancelBulkOrders(CancelBulkOrdersRequest $request, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/cancel/bulk",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [BulkCancelOrderResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint cancels all open [orders](/glossary#orders) that match the specified filters. Use the `market` parameter to target a single trading pair, or omit the parameter to cancel across all markets. The `type` parameter filters by order type (`spot`, `margin`, `futures`). When omitted, the endpoint targets all order types.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     * - `30` - default validation error code
     * - `31` - market validation failed
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market is not available."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "type": ["The type must be an array."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": [
     *       "Market field should be a string.",
     *       "Market field format is invalid."
     *     ]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param CancelAllOrdersRequest $request
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
    public function cancelAllOrders(CancelAllOrdersRequest $request, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/cancel/all",
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
     * The endpoint retrieves [active orders](/glossary#active-orders) (orders not yet executed). The response includes limit, stop-limit, and stop-market orders that remain open on the order book. Use the `market` parameter to filter by trading pair, or omit the parameter to retrieve orders across all markets. The endpoint supports pagination with `limit` and `offset` parameters.
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * Search across all markets is available only if clientOrderId and orderId are not provided.
     * </Note>
     *
     * <Note>
     * This endpoint supports pagination. Use `limit` (default: 50, max: 100) and `offset` (default: 0, max: 4294967295) to page through results. The response does not include a `total` field — detect the last page when fewer than `limit` orders are returned. An empty array means you have paged past the end; receiving exactly `limit` orders does not guarantee that another page exists.
     * </Note>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market is not available"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "limit": ["The limit may not be greater than 100."],
     *     "offset": ["The offset may not be greater than 4294967295."]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param GetActiveOrdersRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<OrderResponse>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getActiveOrders(GetActiveOrdersRequest $request = new GetActiveOrdersRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/orders",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [OrderResponse::class]); // @phpstan-ignore-line
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
     * The endpoint retrieves executed order history for all trading types — spot, margin, and futures — across all markets. Can be filtered by a single market if needed. Results are ordered by trade time, newest first.
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Warning>
     * Requests with `limit` values above 100 return large payloads. Use high limits only when necessary and ensure the client application can handle large response sizes.
     * </Warning>
     *
     * <Note>
     * The endpoint can retrieve data not older than 6 months from the current month. For older data, use the Report on the History page.
     * </Note>
     *
     * <Note>
     * This endpoint supports pagination. Use `limit` (default: 50, max: 500) and `offset` (default: 0) to page through results. The response does not include a `total` field — detect the last page when fewer than `limit` records are returned (sum the records across all markets when no `market` filter is set). An empty response means you have paged past the end; receiving exactly `limit` records does not guarantee that another page exists.
     * </Note>
     *
     * <Note>
     * For B2B accounts, canceled orders are not recorded in the history. To obtain canceled-order data, contact support or the assigned account manager.
     * </Note>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "limit": ["Limit field should be an integer."],
     *     "offset": ["Offset field should be an integer."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market field format is invalid."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "orderHistory": ["OrderHistory was not found."]
     *   }
     * }
     * ```
     * Returned when `clientOrderId` is supplied but no order matches it on the calling account.
     * </Accordion>
     *
     * @param GetExecutedOrderHistoryRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return (
     *    array<ExecutedDeal>
     *   |array<string, array<ExecutedDeal>>
     * )
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getExecutedOrderHistory(GetExecutedOrderHistoryRequest $request = new GetExecutedOrderHistoryRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/trade-account/executed-history",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeUnion($json, new Union([ExecutedDeal::class], ['string' => [ExecutedDeal::class]])); // @phpstan-ignore-line
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
     * The endpoint retrieves individual trade fills (deals) for a specific order. Each deal represents a partial or full execution of the order against a counterparty. The response includes pagination and returns deal details such as price, amount, fee, and execution role (maker or taker).
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * This endpoint supports pagination. Use `limit` (default: 50) and `offset` (default: 0) to page through results. The response does not include a `total` field — detect the last page when `records.length < limit`. An empty `records` array means you have paged past the end; receiving exactly `limit` records does not guarantee that another page exists.
     * </Note>
     *
     * <Note>
     * An unknown or not-owned `orderId` is **not** an error. The endpoint always returns HTTP 200 with the paged-list envelope; a non-matching `orderId` simply filters down to an empty `records` array.
     * </Note>
     *
     * <Note>
     * The endpoint can retrieve data not older than 6 months from the current month. For older data, use the Report on the History page. An order older than this window returns an empty `records` array even when the order was filled.
     * </Note>
     *
     * <Accordion title="Error Codes">
     *   - `30` - default validation error code (for example, a missing or malformed `orderId`, or invalid pagination)
     * </Accordion>
     *
     * @param GetOrderDealsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetOrderDealsResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getOrderDeals(GetOrderDealsRequest $request, ?array $options = null): GetOrderDealsResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/trade-account/order",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetOrderDealsResponse::fromJson($json);
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
     * The endpoint retrieves the history of executed and cancelled orders. The response groups orders by market name. Use the `market` parameter to filter by a single trading pair, or omit the parameter to retrieve orders across all markets. The endpoint supports pagination with `limit` (default 50, max 500) and `offset` parameters. Results are ordered by time, newest first.
     *
     * <Warning>
     * Rate limit: 12000 requests/10 sec.
     * </Warning>
     *
     * <Warning>
     * Requests with `limit` values above 100 return large payloads. Use high limits only when necessary and ensure the client application can handle large response sizes.
     * </Warning>
     *
     * <Note>
     * This endpoint supports pagination. Use `limit` (default: 50, max: 500) and `offset` (default: 0) to page through results. The response does not include a `total` field — detect the last page when fewer than `limit` records are returned (sum the records across all markets when no `market` filter is set). An empty response means you have paged past the end; receiving exactly `limit` records does not guarantee that another page exists.
     * </Note>
     *
     * <Note>
     * **Date filter window:** the maximum span between `startDate` and `endDate` is **31 days**, and the earliest reachable date is **6 months ago (00:00 UTC)**. Requests that exceed the 31-day window or fall below the 6-month floor are rejected with a validation error. `endDate` values greater than the current time are silently clamped to `now`.
     * </Note>
     *
     * <Note>
     * For B2B accounts, canceled orders are not recorded in the history. To obtain canceled-order data, contact support or the assigned account manager.
     * </Note>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "orderHistory": ["OrderHistory was not found."]
     *   }
     * }
     * ```
     * Returned when `clientOrderId` is supplied but no order matches it on the calling account.
     * </Accordion>
     *
     * @param GetOrderHistoryRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<string, array<GetOrderHistoryResponseValueItem>>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getOrderHistory(GetOrderHistoryRequest $request = new GetOrderHistoryRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/trade-account/order/history",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, ['string' => [GetOrderHistoryResponseValueItem::class]]); // @phpstan-ignore-line
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
     * The endpoint returns the authenticated account's delisting-related order history from the order-history index. The response combines two categories of orders, each identified by the `delistingKind` field: reverse close orders that the platform generates when a market is delisted (`delistingKind` = `reverse`, `clientOrderId` prefixed with `delisting-`), and active orders canceled at the moment of delisting (`delistingKind` = `canceled`). The endpoint returns a flat array sorted by `finishAt` descending, then `id` descending.
     *
     * Set the `status` parameter to narrow the response: `filled` returns only reverse close orders that reached the `filled` outcome, and `delisting` returns only orders canceled during delisting. Omit `status` to return both categories merged in a single array.
     *
     * <Note>
     * The endpoint supports pagination via `limit` (default: 500, max: 500) and `offset` (default: 0); the sum of `offset` and `limit` must not exceed 10000. A response that returns fewer than `limit` records indicates the last page.
     * </Note>
     *
     * <Note>
     * **Date filter window:** the date range filters orders by the `finishAt` timestamp. The maximum span between `startDate` and `endDate` is **31 days**. `endDate` values greater than the current time are clamped to `now`.
     * </Note>
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * @param GetDelistingOrderHistoryRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<GetDelistingOrderHistoryResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getDelistingOrderHistory(GetDelistingOrderHistoryRequest $request = new GetDelistingOrderHistoryRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/trade-account/order/history/query",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [GetDelistingOrderHistoryResponseItem::class]); // @phpstan-ignore-line
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
     * The endpoint modifies existing [order](/glossary#orders).
     *
     * Supported order types: limit, stop limit, stop market.
     *
     * Request must contain at least one of the following parameters: amount, total, price, activationPrice.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * - Use total parameter instead of amount for modify buy stop market order. `amount` and `total` are mutually exclusive — a request sending both is rejected.
     * - The request accepts exactly one identifier: either `orderId` or `clientOrderId`.
     * - Sending both identifiers, or neither, returns a validation error.
     * </Note>
     *
     * <Note>
     * **WebSocket impact:** Each call to the endpoint cancels the original order and
     * creates a replacement with a **new `orderId`**. Clients subscribed to the
     * `ordersPending_update` WebSocket channel will receive:
     * - `event_id=3` (cancel) for the old order
     * - `event_id=1` (new) for the replacement
     *
     * Update any `orderId` references after a successful modify response.
     * Use `clientOrderId` for stable order tracking across modifications.
     * </Note>
     *
     * <Accordion title="Error Codes">
     * **Status 400** (client errors): 1, 2, 6, 20, 24, 101, 158
     *
     * **Status 422** (business logic): 10, 11, 12, 13, 14, 15, 16, 17, 25, 27, 40, 42, 51, 103, 104, 105, 106, 111, 112, 113, 114, 115, 150, 151, 152, 153, 155, 157, 159, 160, 161, 162, 163, 250, 251, 300, 302, 330
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market is not available."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 2,
     *   "message": "Inner validation failed",
     *   "errors": {
     *     "orderId": ["Unexecuted order was not found."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 10,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Not enough balance."]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param ModifyOrderRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return OrderResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function modifyOrder(ModifyOrderRequest $request, ?array $options = null): OrderResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/modify",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return OrderResponse::fromJson($json);
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
     * The endpoint creates, updates, or deletes a [kill-switch timer](/glossary#kill-switch-timer). The kill-switch acts as a safety mechanism for automated trading systems — the timer automatically cancels all open orders for the specified market if the client fails to reset the timer before expiration. Set `timeout` to a value between `5` and `600` (seconds) to create or update a timer. Set `timeout` to `null` to delete an existing timer.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * - If timeout=null - delete existing timer by market.
     * - If types=null - create timer by market for all order types.
     * </Note>
     *
     * <Accordion title="Error Codes">
     * - `30` - default validation error code
     * - `31` - market validation failed
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market field is required."],
     *     "timeout": ["Timeout field is required."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market is not available."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "timeout": ["Timeout should be at least 5."]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param SetKillSwitchRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return (
     *    SetKillSwitchResponseCancellationTime
     *   |array<mixed>
     * )
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function setKillSwitch(SetKillSwitchRequest $request, ?array $options = null): SetKillSwitchResponseCancellationTime|array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/kill-switch",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeUnion($json, new Union(SetKillSwitchResponseCancellationTime::class, ['mixed'])); // @phpstan-ignore-line
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
     * The endpoint retrieves the status of active [kill-switch timers](/glossary#kill-switch-timer). The response returns an array of timer objects for the specified market, or for all markets if the `market` parameter is omitted. Each timer object includes the start time, scheduled cancellation time, and targeted order types.
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Accordion title="Error Codes">
     * - `30` - default validation error code
     * - `31` - market validation failed
     * </Accordion>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 31,
     *   "message": "Validation failed",
     *   "errors": {
     *     "market": ["Market is not available."]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * @param GetKillSwitchStatusRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<GetKillSwitchStatusResponseItem>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getKillSwitchStatus(GetKillSwitchStatusRequest $request = new GetKillSwitchStatusRequest(), ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/order/kill-switch/status",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, [GetKillSwitchStatusResponseItem::class]); // @phpstan-ignore-line
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
