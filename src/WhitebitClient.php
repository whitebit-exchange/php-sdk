<?php

namespace Whitebit;

use Whitebit\PublicApiV4\PublicApiV4Client;
use Whitebit\MainAccount\MainAccountClient;
use Whitebit\Deposit\DepositClient;
use Whitebit\Jwt\JwtClient;
use Whitebit\Withdraw\WithdrawClient;
use Whitebit\Transfer\TransferClient;
use Whitebit\Codes\CodesClient;
use Whitebit\CryptoLendingFixed\CryptoLendingFixedClient;
use Whitebit\CryptoLendingFlex\CryptoLendingFlexClient;
use Whitebit\Fees\FeesClient;
use Whitebit\SubAccount\SubAccountClient;
use Whitebit\SubAccountApiKeys\SubAccountApiKeysClient;
use Whitebit\MiningPool\MiningPoolClient;
use Whitebit\CreditLine\CreditLineClient;
use Whitebit\TravelRule\TravelRuleClient;
use Whitebit\CollateralTrading\CollateralTradingClient;
use Whitebit\MarketFee\MarketFeeClient;
use Whitebit\SpotTrading\SpotTradingClient;
use Psr\Http\Client\ClientInterface;
use Whitebit\Core\Client\RawClient;
use Whitebit\Requests\ConvertEstimateRequest;
use Whitebit\Types\ConvertEstimateResponse;
use Whitebit\Exceptions\WhitebitException;
use Whitebit\Exceptions\WhitebitApiException;
use Whitebit\Core\Json\JsonApiRequest;
use Whitebit\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Whitebit\Requests\ConvertConfirmRequest;
use Whitebit\Types\ConvertConfirmResponse;
use Whitebit\Requests\ConvertHistoryRequest;
use Whitebit\Types\ConvertHistoryResponse;

class WhitebitClient
{
    /**
     * @var PublicApiV4Client $publicApiV4
     */
    public PublicApiV4Client $publicApiV4;

    /**
     * @var MainAccountClient $mainAccount
     */
    public MainAccountClient $mainAccount;

    /**
     * @var DepositClient $deposit
     */
    public DepositClient $deposit;

    /**
     * @var JwtClient $jwt
     */
    public JwtClient $jwt;

    /**
     * @var WithdrawClient $withdraw
     */
    public WithdrawClient $withdraw;

    /**
     * @var TransferClient $transfer
     */
    public TransferClient $transfer;

    /**
     * @var CodesClient $codes
     */
    public CodesClient $codes;

    /**
     * @var CryptoLendingFixedClient $cryptoLendingFixed
     */
    public CryptoLendingFixedClient $cryptoLendingFixed;

    /**
     * @var CryptoLendingFlexClient $cryptoLendingFlex
     */
    public CryptoLendingFlexClient $cryptoLendingFlex;

    /**
     * @var FeesClient $fees
     */
    public FeesClient $fees;

    /**
     * @var SubAccountClient $subAccount
     */
    public SubAccountClient $subAccount;

    /**
     * @var SubAccountApiKeysClient $subAccountApiKeys
     */
    public SubAccountApiKeysClient $subAccountApiKeys;

    /**
     * @var MiningPoolClient $miningPool
     */
    public MiningPoolClient $miningPool;

    /**
     * @var CreditLineClient $creditLine
     */
    public CreditLineClient $creditLine;

    /**
     * @var TravelRuleClient $travelRule
     */
    public TravelRuleClient $travelRule;

    /**
     * @var CollateralTradingClient $collateralTrading
     */
    public CollateralTradingClient $collateralTrading;

    /**
     * @var MarketFeeClient $marketFee
     */
    public MarketFeeClient $marketFee;

    /**
     * @var SpotTradingClient $spotTrading
     */
    public SpotTradingClient $spotTrading;

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
     * @param string $apiKey The apiKey to use for authentication.
     * @param string $txcPayload
     * @param string $txcSignature
     * @param ?Environments $environment The environment to use for API requests.
     * @param ?array{
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options
     */
    public function __construct(
        string $apiKey,
        string $txcPayload,
        string $txcSignature,
        ?Environments $environment = null,
        ?array $options = null,
    ) {
        $defaultHeaders = [
            'X-TXC-APIKEY' => $apiKey,
            'X-TXC-PAYLOAD' => $txcPayload,
            'X-TXC-SIGNATURE' => $txcSignature,
            'X-Fern-Language' => 'PHP',
            'X-Fern-SDK-Name' => 'Whitebit',
        ];

        $this->options = $options ?? [];
        $environment ??= Environments::Default_();
        $this->environment = $environment;

        $this->options['headers'] = array_merge(
            $defaultHeaders,
            $this->options['headers'] ?? [],
        );

        $this->client = new RawClient(
            options: $this->options,
        );

        $this->publicApiV4 = new PublicApiV4Client($this->client, $this->environment);
        $this->mainAccount = new MainAccountClient($this->client, $this->environment);
        $this->deposit = new DepositClient($this->client, $this->environment);
        $this->jwt = new JwtClient($this->client, $this->environment);
        $this->withdraw = new WithdrawClient($this->client, $this->environment);
        $this->transfer = new TransferClient($this->client, $this->environment);
        $this->codes = new CodesClient($this->client, $this->environment);
        $this->cryptoLendingFixed = new CryptoLendingFixedClient($this->client, $this->environment);
        $this->cryptoLendingFlex = new CryptoLendingFlexClient($this->client, $this->environment);
        $this->fees = new FeesClient($this->client, $this->environment);
        $this->subAccount = new SubAccountClient($this->client, $this->environment);
        $this->subAccountApiKeys = new SubAccountApiKeysClient($this->client, $this->environment);
        $this->miningPool = new MiningPoolClient($this->client, $this->environment);
        $this->creditLine = new CreditLineClient($this->client, $this->environment);
        $this->travelRule = new TravelRuleClient($this->client, $this->environment);
        $this->collateralTrading = new CollateralTradingClient($this->client, $this->environment);
        $this->marketFee = new MarketFeeClient($this->client, $this->environment);
        $this->spotTrading = new SpotTradingClient($this->client, $this->environment);
    }

    /**
     * The endpoint creates a quote for converting one currency to another. Quote lifetime is 10 seconds, then quote will be expired.
     *
     * The minimum convert size is derived from the resulting proceeds, not a fixed per-pair floor: a request is rejected as too small when `rate × amount` rounds to zero in the target currency. Account balance is pre-checked at estimate time and re-checked at confirm time, because balance can change within the 10-second quote window. There is an absolute server-side maximum on the conversion amount.
     *
     * <Note>
     * The endpoint can be used to obtain a pre-execution price estimate for a market order. Call the endpoint with the desired amount before placing a market order to see the approximate execution price.
     * </Note>
     *
     * <Note>
     * Error `message` values may be returned as translation keys (for example `validation.required`) rather than finalized English strings. Treat the `code` and the field name under `errors` as the stable contract.
     * </Note>
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * @param ConvertEstimateRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ConvertEstimateResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function convertEstimate(ConvertEstimateRequest $request, ?array $options = null): ConvertEstimateResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/convert/estimate",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ConvertEstimateResponse::fromJson($json);
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
     * The endpoint confirms an estimated quote.
     *
     * An expired quote returns code `20` (`api.converter.quoteExpired`), which is distinct from a quote that could not be found (code `0`). Balance is re-checked at confirm time and can fail with code `37` even when the estimate succeeded, because balance may change within the 10-second quote window.
     *
     * <Note>
     * A re-confirmed (already used) quote and a quote that never existed both return code `0` with the `quoteId` field key `frontendServerSide.converter.quoteInvalid`. The response alone does not distinguish "already used" from "never existed".
     * </Note>
     *
     * <Note>
     * Error `message` values may be returned as translation keys (for example `api.converter.quoteExpired`) rather than finalized English strings. Treat the `code` and the field name under `errors` as the stable contract.
     * </Note>
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * @param ConvertConfirmRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ConvertConfirmResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function convertConfirm(ConvertConfirmRequest $request, ?array $options = null): ConvertConfirmResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/convert/confirm",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ConvertConfirmResponse::fromJson($json);
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
     * The endpoint returns convert history, sorted by `id` descending (newest first).
     *
     * The `from`–`to` window is capped at 30 days per request, even though data is retained for 6 months. A wider range is rejected with code `30` (`api.validation.dateTime.maxRange`).
     *
     * <Warning>
     * Rate limit: 10000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * Error `message` values may be returned as translation keys (for example `api.validation.dateTime.maxRange`) rather than finalized English strings. Treat the `code` and the field name under `errors` as the stable contract.
     * </Note>
     *
     * **Note:** The endpoint can retrieve data not older than 6 months from the current month. For older data, use the Report on the History page.
     *
     * @param ConvertHistoryRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ConvertHistoryResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function convertHistory(ConvertHistoryRequest $request = new ConvertHistoryRequest(), ?array $options = null): ConvertHistoryResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/convert/history",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ConvertHistoryResponse::fromJson($json);
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
