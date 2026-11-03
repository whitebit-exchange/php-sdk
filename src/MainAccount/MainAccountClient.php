<?php

namespace Whitebit\MainAccount;

use Psr\Http\Client\ClientInterface;
use Whitebit\Core\Client\RawClient;
use Whitebit\Environments;
use Whitebit\MainAccount\Requests\GetMainBalanceRequest;
use Whitebit\MainAccount\Types\GetMainBalanceResponseValue;
use Whitebit\Exceptions\WhitebitException;
use Whitebit\Exceptions\WhitebitApiException;
use Whitebit\Core\Json\JsonApiRequest;
use Whitebit\Core\Client\HttpMethod;
use Whitebit\Core\Json\JsonDecoder;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Whitebit\MainAccount\Requests\GetDepositWithdrawHistoryRequest;
use Whitebit\MainAccount\Types\GetDepositWithdrawHistoryResponse;

class MainAccountClient
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
     * The endpoint retrieves the [main balance](/glossary#balance-main) by currency [ticker](/glossary#ticker) or all balances.
     *
     * An unknown or non-existent `ticker` is not an error: the endpoint returns a zero balance (`{"main_balance": "0"}`) for it. Omitting `ticker` returns balances for every currency.
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "ticker": ["validation.string"]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * Beyond the validation error above, this endpoint can return only the [common authentication errors](/api-reference/authentication).
     *
     * <Warning>
     *   Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param GetMainBalanceRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return array<string, GetMainBalanceResponseValue>
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getMainBalance(GetMainBalanceRequest $request, ?array $options = null): array
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/balance",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return JsonDecoder::decodeArray($json, ['string' => GetMainBalanceResponseValue::class]); // @phpstan-ignore-line
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
     * The endpoint retrieves the history of deposits and withdraws.
     *
     * **Deposit status codes:**
     * - `Successful` - 3, 7
     * - `Canceled` - 4, 9
     * - `Unconfirmed by user` - 5
     * - `AML frozen` - 21
     * - `Uncredited` - 22
     * - `Pending` - 15
     *
     * `Successful` (3, 7) is a final state. A credited deposit does not later transition to `AML frozen` (21) or `Uncredited` (22); those checks happen before crediting.
     *
     * **Travel Rule Deposit check status codes:**
     * - `Awaiting verification` - 27: The transaction has been frozen due to the lack of data required under the Travel Rule. The user is required to provide this data manually through the exchange interface.
     * - `Confirmation in progress` - 28: The Travel Rule data provided by the user is currently being verified by WhiteBIT.
     *
     * ⚠️ Due to regulatory requirements in Turkey and [EU](/glossary#european-economic-area-eea), the system places every inbound crypto deposit on hold (frozen) until confirming the transaction's origin. The sender must provide certain details if the transaction is from another Virtual Asset Service Provider (VASP) or verify the address if from a self-hosted wallet. The system credits deposited funds to the account only after successful verification.
     *
     * **Withdraw status codes:**
     * - `Pending` - 1, 2, 6, 10–17 (withdrawal in progress).
     * - `Successful` - 3, 7
     * - `Canceled` - 4
     * - `Unconfirmed by user` - 5
     * - `AML frozen` - 21
     * - `Partially successful` - 18
     *
     * <Warning>
     * Rate limit: 200 requests/10 sec.
     * </Warning>
     *
     * <Warning>
     * Requests with `limit` values above 100 return large payloads. Use high limits only when necessary and ensure the client application can handle large response sizes.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * <Note>
     * Results are sorted newest first (descending by timestamp).
     * </Note>
     *
     * <Note>
     * **No date filtering:** the endpoint does not accept `startDate` / `endDate` parameters, and pagination is capped at `offset + limit ≤ 10000` (requests beyond the cap return `Offset is too big. Please use offset + limit less than 10000.`). To read more than 10,000 records, narrow the result set with the available filters (`transactionMethod`, `ticker`, `status`) and paginate within each subset; for a complete history export beyond the cap, use the Report on the History page.
     * </Note>
     *
     * @param GetDepositWithdrawHistoryRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetDepositWithdrawHistoryResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getDepositWithdrawHistory(GetDepositWithdrawHistoryRequest $request, ?array $options = null): GetDepositWithdrawHistoryResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/main-account/history",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetDepositWithdrawHistoryResponse::fromJson($json);
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
