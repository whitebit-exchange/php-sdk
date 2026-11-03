<?php

namespace Whitebit\Withdraw;

use Psr\Http\Client\ClientInterface;
use Whitebit\Core\Client\RawClient;
use Whitebit\Environments;
use Whitebit\Withdraw\Requests\CreateWithdrawRequest;
use Whitebit\Exceptions\WhitebitException;
use Whitebit\Exceptions\WhitebitApiException;
use Whitebit\Core\Json\JsonApiRequest;
use Whitebit\Core\Client\HttpMethod;
use Whitebit\Core\Json\JsonDecoder;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Whitebit\Withdraw\Requests\WithdrawRequest;
use Whitebit\Withdraw\Requests\CreateExpressWithdrawTokenRequest;
use Whitebit\Withdraw\Types\CreateExpressWithdrawTokenResponse;

class WithdrawClient
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
     * The endpoint creates withdraw for the specified ticker.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * <Note>
     * Also, fiat currencies can't be withdrawn without KYC verification.
     * </Note>
     *
     * @param CreateWithdrawRequest $request
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
    public function createWithdraw(CreateWithdrawRequest $request, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/withdraw",
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
     * The endpoint has the similar logic as /main-account/withdraw, but with the only difference: amount that is specified will not include [fee](/glossary#fee) (it will be calculated to make target withdraw amount equal to the specified amount).
     *
     * **Example:**
     * - When creating a base withdraw with amount = 100 USD, the receiver receives 100 USD minus the [fee](/glossary#fee), and the balance decreases by 100 USD.
     * - When using this endpoint with amount = 100 USD, the receiver receives 100 USD, and the balance decreases by 100 USD plus the [fee](/glossary#fee).
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param WithdrawRequest $request
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
    public function createWithdrawPay(WithdrawRequest $request, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/withdraw-pay",
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
     * The endpoint creates a signed, single-use Express Withdraw payment token that charges a specific amount from a WhiteBIT user's balance to the partner's [Main balance](/glossary#balance-main) in an instant, off-chain, zero-[fee](/glossary#fee) internal transfer. The response returns a URL that embeds the token; the paying user confirms the exact [ticker](/glossary#ticker) and amount on the WhiteBIT-hosted confirmation surface.
     *
     * Token and payment constraints:
     * - Each token is single-use: WhiteBIT marks the token used at confirmation and rejects any replay.
     * - Each token expires 90 seconds after creation; the `expireAt` response field carries the authoritative expiry timestamp. Generate the token as close as possible to the moment of presenting the URL to the user.
     * - The [ticker](/glossary#ticker) must be a withdrawal-enabled cryptocurrency; the endpoint rejects [fiat](/glossary#fiat) tickers.
     * - Each payment is capped at the equivalent of 10,000 USDT; WhiteBIT enforces the cap at token creation and re-enforces the cap at confirmation.
     * - WhiteBIT rejects self-payments: the paying user and the token creator must be different WhiteBIT accounts.
     * - The endpoint is idempotent per `externalId`: re-submitting the same `externalId` with an identical `ticker` and `amount` while the token is still valid returns the same token instead of creating a duplicate charge. After the token expires, the same `externalId` receives a fresh token.
     *
     * <Note>
     * Standard private-API rate limits apply — see [Rate limits](/api-reference/rate-limits). The endpoint carries no endpoint-specific limit.
     * </Note>
     *
     * @param CreateExpressWithdrawTokenRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CreateExpressWithdrawTokenResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createExpressWithdrawToken(CreateExpressWithdrawTokenRequest $request, ?array $options = null): CreateExpressWithdrawTokenResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/express-withdraw/token",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CreateExpressWithdrawTokenResponse::fromJson($json);
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
