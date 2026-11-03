<?php

namespace Whitebit\Deposit;

use Psr\Http\Client\ClientInterface;
use Whitebit\Core\Client\RawClient;
use Whitebit\Environments;
use Whitebit\Deposit\Requests\GetDepositAddressRequest;
use Whitebit\Deposit\Types\GetDepositAddressResponse;
use Whitebit\Exceptions\WhitebitException;
use Whitebit\Exceptions\WhitebitApiException;
use Whitebit\Core\Json\JsonApiRequest;
use Whitebit\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Whitebit\Deposit\Requests\GetFiatDepositUrlRequest;
use Whitebit\Deposit\Types\GetFiatDepositUrlResponse;
use Whitebit\Deposit\Requests\IssueCardTokenRequest;
use Whitebit\Deposit\Requests\RefundDepositRequest;
use Whitebit\Deposit\Types\RefundDepositResponse;
use Whitebit\Deposit\Requests\CreateNewAddressRequest;
use Whitebit\Deposit\Types\CreateNewAddressResponse;

class DepositClient
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
     * The endpoint retrieves a deposit address of the cryptocurrency.
     *
     * <Note>
     * Sub-accounts use this endpoint with their own API key once deposits are enabled for the
     * account. Crypto deposits are disabled by default — to enable them, contact your assigned
     * Account Manager or email institutional@whitebit.com.
     * </Note>
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "ticker": ["The selected ticker is invalid."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "network": ["The selected network is invalid."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 1,
     *   "message": "Inner validation failed",
     *   "errors": {
     *     "ticker": ["Currency is not depositable"]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param GetDepositAddressRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetDepositAddressResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getDepositAddress(GetDepositAddressRequest $request, ?array $options = null): GetDepositAddressResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/address",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetDepositAddressResponse::fromJson($json);
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
     * The endpoint retrieves a deposit url of the [fiat](/glossary#fiat) invoice.
     *
     * The endpoint works on demand. Contact WhiteBIT support and provide the API key to get access to the functionality.
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount is too little for deposit"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "provider": ["Cannot find currency for specified provider"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "uniqueId": ["The unique id has already been taken."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["The amount must be a number."],
     *     "provider": ["The selected provider is invalid."],
     *     "ticker": ["The selected ticker is invalid."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 10,
     *   "message": "Failed to generate deposit url"
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["The amount field is required."],
     *     "provider": ["The provider field is required."],
     *     "ticker": ["The ticker field is required."],
     *     "uniqueId": ["The unique id field is required."]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "successLink": [
     *       "Your domain is incorrect. Please contact support for more details"
     *     ],
     *     "failureLink": [
     *       "Your domain is incorrect. Please contact support for more details"
     *     ]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "success": false,
     *   "message": "You don't have permission to use this endpoint. Please contact support for more details",
     *   "code": 0
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "successLink": ["Your domain scheme incorrect. Use https only"],
     *     "failureLink": ["Your domain scheme incorrect. Use https only"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "ticker": ["Currency is not depositable via API"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "user": ["User not verified"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Amount is too big for deposit"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Daily limit reached"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "amount": ["Expiration date cannot be used for this provider"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "customer.birthDate": ["You must be at least 18 years old"]
     *   }
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "address": ["Invalid credit card number"]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * <Warning>
     * When using VISAMASTER as [provider](/glossary#provider), pass the [referer header](https://developer.mozilla.org/ru/docs/Web/HTTP/Headers/Referer) when opening the invoice link (e.g. when opening https://someaddress.com). If the header is missing (e.g. when opening the link from a Telegram message), the browser is redirected to the WhiteBIT homepage
     * </Warning>
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param GetFiatDepositUrlRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetFiatDepositUrlResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getFiatDepositUrl(GetFiatDepositUrlRequest $request, ?array $options = null): GetFiatDepositUrlResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/fiat-deposit-url",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetFiatDepositUrlResponse::fromJson($json);
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
     * The endpoint issues a [card token](/glossary#card-token) for the specified card number.
     *
     * **Request Headers:**
     * - `Authorization`: JWT token from the [Issue JWT token](/private/http-main-v4/issue-jwt-token) response field `data.token` (**Required**)
     * - `Content-Type`: `application/json` (**Required**)
     *
     * Use the `data.token` value returned by [Issue JWT token](/private/http-main-v4/issue-jwt-token) as the `Authorization` header when calling this Fiat Gateway endpoint.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param IssueCardTokenRequest $request
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
    public function issueCardToken(IssueCardTokenRequest $request, ?array $options = null): void
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/card-token",
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
     * Refund a deposit.
     *
     * The system processes refunds only for deposits with status `canceled`.
     *
     * Obtain `transactionId` from the `deposit.canceled` webhook (`uniqueId`) or from the deposit/withdraw history in the WhiteBIT interface after support confirms refund availability.
     *
     * The refund address must support the same network and asset as the original deposit. The refund address must not be a WhiteBIT address. The refund address can differ from the original deposit sender address.
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 0,
     *   "message": "Transaction not refundable"
     * }
     * ```
     *
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "transactionId": ["The transaction id field is required."],
     *     "address": ["The address field is required."]
     *   }
     * }
     * ```
     * </Accordion>
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
     * Refund processing does not complete instantly. Use the [refund.successful](/platform/webhook#whitebit-refund-successful) and [refund.failed](/platform/webhook#whitebit-refund-failed) webhooks to receive refund status updates.
     * </Note>
     *
     * @param RefundDepositRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return RefundDepositResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function refundDeposit(RefundDepositRequest $request, ?array $options = null): RefundDepositResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/refund-deposit",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return RefundDepositResponse::fromJson($json);
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
     * The endpoint creates a new address even when the last created address is not used. The endpoint is not available by default, contact support@whitebit.com to get permissions to use the endpoint.
     *
     * <Note>
     * For sub-accounts, crypto deposits must also be enabled for the account (disabled by
     * default). To enable them, contact your assigned Account Manager or email institutional@whitebit.com.
     * </Note>
     *
     * **Address types:**
     *
     * | Currency | Types               | Default |
     * |----------|---------------------|---------|
     * | BTC      | p2sh-segwit, bech32 | bech32  |
     * | LTC      | p2sh-segwit, bech32 | bech32  |
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param CreateNewAddressRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CreateNewAddressResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createNewAddress(CreateNewAddressRequest $request, ?array $options = null): CreateNewAddressResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/create-new-address",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CreateNewAddressResponse::fromJson($json);
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
