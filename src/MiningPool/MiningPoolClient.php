<?php

namespace Whitebit\MiningPool;

use Psr\Http\Client\ClientInterface;
use Whitebit\Core\Client\RawClient;
use Whitebit\Environments;
use Whitebit\MiningPool\Requests\GetMiningRewardsRequest;
use Whitebit\MiningPool\Types\GetMiningRewardsResponse;
use Whitebit\Exceptions\WhitebitException;
use Whitebit\Exceptions\WhitebitApiException;
use Whitebit\Core\Json\JsonApiRequest;
use Whitebit\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Whitebit\MiningPool\Requests\GetMiningHashrateRequest;
use Whitebit\MiningPool\Types\GetMiningHashrateResponse;
use Whitebit\MiningPool\Requests\GetMiningPayoutDestinationRequest;
use Whitebit\MiningPool\Types\GetMiningPayoutDestinationResponse;
use Whitebit\MiningPool\Requests\SetMiningPayoutDestinationRequest;
use Whitebit\MiningPool\Types\SetMiningPayoutDestinationResponse;
use Whitebit\MiningPool\Requests\GetMiningMinerInfoRequest;
use Whitebit\MiningPool\Types\GetMiningMinerInfoResponse;
use Whitebit\MiningPool\Requests\GetMiningWorkerNamesRequest;
use Whitebit\MiningPool\Types\GetMiningWorkerNamesResponse;
use Whitebit\MiningPool\Requests\GetMiningWorkerHashrateRequest;
use Whitebit\MiningPool\Types\GetMiningWorkerHashrateResponse;
use Whitebit\MiningPool\Requests\CreateMiningWatcherLinkRequest;
use Whitebit\MiningPool\Types\CreateMiningWatcherLinkResponse;
use Whitebit\MiningPool\Requests\ListMiningWatcherLinksRequest;
use Whitebit\MiningPool\Types\ListMiningWatcherLinksResponse;
use Whitebit\MiningPool\Requests\CreateMiningAccountRequest;
use Whitebit\MiningPool\Types\CreateMiningAccountResponse;
use Whitebit\MiningPool\Requests\GetMiningAccountsRequest;
use Whitebit\MiningPool\Types\GetMiningAccountsResponse;

class MiningPoolClient
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
     * The endpoint returns rewards received from mining.
     * Results are ordered by reward date, newest first.
     *
     * The response does not include a `total` field. Detect the last page when
     * `data.length < limit`.
     *
     * The `offset` parameter is capped at 10000. To paginate reward histories
     * beyond that, window the request by `from` and `to` (Unix timestamps).
     *
     * <Note>
     * The `account` filter is not validated at the request layer. An unknown or
     * not-owned account name is treated as an empty filter and returns HTTP `200`
     * with an empty `data` array — the same response as a valid account with no
     * rewards in the requested window. An account without mining access also
     * returns empty data, so an empty response does not distinguish "no mining
     * access" from "no rewards in range."
     * </Note>
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param GetMiningRewardsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetMiningRewardsResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getMiningRewards(GetMiningRewardsRequest $request = new GetMiningRewardsRequest(), ?array $options = null): GetMiningRewardsResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/mining/rewards",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetMiningRewardsResponse::fromJson($json);
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
     * The endpoint returns hashrate of mining pool account.
     *
     * <Note>
     * There is no dedicated "mining not enabled" error. An account that is
     * administratively disabled for mining returns HTTP `200` with empty data
     * rather than an error.
     * </Note>
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param GetMiningHashrateRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetMiningHashrateResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getMiningHashrate(GetMiningHashrateRequest $request, ?array $options = null): GetMiningHashrateResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/mining/hashrate",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetMiningHashrateResponse::fromJson($json);
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
     * Returns the current payout destination setting for a specific mining account belonging to the authenticated user.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * @param GetMiningPayoutDestinationRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetMiningPayoutDestinationResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getMiningPayoutDestination(GetMiningPayoutDestinationRequest $request, ?array $options = null): GetMiningPayoutDestinationResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/mining/payout-destination",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetMiningPayoutDestinationResponse::fromJson($json);
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
     * Updates the payout destination for a specific mining account belonging to the authenticated user. Can be set to main balance or an external BTC address.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * @param SetMiningPayoutDestinationRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return SetMiningPayoutDestinationResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function setMiningPayoutDestination(SetMiningPayoutDestinationRequest $request, ?array $options = null): SetMiningPayoutDestinationResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/mining/payout-destination/edit",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return SetMiningPayoutDestinationResponse::fromJson($json);
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
     * Returns fee information and stratum connection details with worker counts for a specific mining account.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * @param GetMiningMinerInfoRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetMiningMinerInfoResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getMiningMinerInfo(GetMiningMinerInfoRequest $request, ?array $options = null): GetMiningMinerInfoResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/mining/miners/info",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetMiningMinerInfoResponse::fromJson($json);
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
     * Returns a paginated list of online worker names for a specific mining account.
     * Results are ordered by worker name ascending (alphabetical).
     *
     * The response does not include a `total` field. Detect the last page when
     * `data.workers.length < limit`.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * @param GetMiningWorkerNamesRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetMiningWorkerNamesResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getMiningWorkerNames(GetMiningWorkerNamesRequest $request, ?array $options = null): GetMiningWorkerNamesResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/mining/workers/names",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetMiningWorkerNamesResponse::fromJson($json);
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
     * Returns hashrate performance history for a specific worker on a mining account.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * @param GetMiningWorkerHashrateRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetMiningWorkerHashrateResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getMiningWorkerHashrate(GetMiningWorkerHashrateRequest $request, ?array $options = null): GetMiningWorkerHashrateResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/mining/workers/hashrate",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetMiningWorkerHashrateResponse::fromJson($json);
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
     * Creates a new watcher link for one or more mining accounts, granting specific permissions with a configurable expiration.
     *
     * <Note>
     * The number of active watcher links per mining account is capped (configurable
     * server-side; currently 3 by default). Exceeding the cap returns a `400` with
     * `Limit exceeded`.
     * </Note>
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * @param CreateMiningWatcherLinkRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CreateMiningWatcherLinkResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createMiningWatcherLink(CreateMiningWatcherLinkRequest $request, ?array $options = null): CreateMiningWatcherLinkResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/mining/watcher-links/create",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CreateMiningWatcherLinkResponse::fromJson($json);
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
     * Returns all active watcher links for a specific mining account.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * @param ListMiningWatcherLinksRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ListMiningWatcherLinksResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function listMiningWatcherLinks(ListMiningWatcherLinksRequest $request, ?array $options = null): ListMiningWatcherLinksResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/mining/watcher-links/list",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return ListMiningWatcherLinksResponse::fromJson($json);
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
     * Creates a new mining account for the authenticated user. The account name must be unique within the user's accounts.
     *
     * <Note>
     * The number of mining accounts per user is capped (configurable server-side).
     * Creating an account beyond the cap returns a `400` with
     * `miningPool.validation.maxAccounts`.
     * </Note>
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * @param CreateMiningAccountRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return CreateMiningAccountResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function createMiningAccount(CreateMiningAccountRequest $request, ?array $options = null): CreateMiningAccountResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/mining/accounts/create",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return CreateMiningAccountResponse::fromJson($json);
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
     * Returns a list of mining accounts for the authenticated user. Supports filtering by account name.
     * Results are ordered by account creation time, newest first.
     *
     * The response does not include a `total` field. Detect the last page when
     * `data.length < limit`.
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * @param GetMiningAccountsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetMiningAccountsResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getMiningAccounts(GetMiningAccountsRequest $request, ?array $options = null): GetMiningAccountsResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/mining/accounts",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetMiningAccountsResponse::fromJson($json);
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
