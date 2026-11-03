<?php

namespace Whitebit\Jwt;

use Psr\Http\Client\ClientInterface;
use Whitebit\Core\Client\RawClient;
use Whitebit\Environments;
use Whitebit\Jwt\Requests\IssueJwtTokenRequest;
use Whitebit\Jwt\Types\IssueJwtTokenResponse;
use Whitebit\Exceptions\WhitebitException;
use Whitebit\Exceptions\WhitebitApiException;
use Whitebit\Core\Json\JsonApiRequest;
use Whitebit\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Whitebit\Jwt\Requests\GetWebSocketTokenRequest;
use Whitebit\Jwt\Types\GetWebSocketTokenResponse;

class JwtClient
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
     * The endpoint issues a JWT token for the Fiat Gateway service.
     * The token is used to authenticate requests to the Fiat Gateway API.
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param IssueJwtTokenRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return IssueJwtTokenResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function issueJwtToken(IssueJwtTokenRequest $request, ?array $options = null): IssueJwtTokenResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/jwt",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return IssueJwtTokenResponse::fromJson($json);
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
     * The V4 endpoint can be used to retrieve the WebSocket token for user.
     * The token is required to authorize WebSocket connections for private API access.
     *
     * <Accordion title="Errors">
     * ```json
     * {
     *   "code": 30,
     *   "message": "Validation failed",
     *   "errors": {
     *     "user": ["user not found"]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * Beyond the error above, this endpoint can return only the [common authentication errors](/api-reference/authentication).
     *
     * <Warning>
     * Rate limit: 10 requests/60 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param GetWebSocketTokenRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetWebSocketTokenResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getWebSocketToken(GetWebSocketTokenRequest $request, ?array $options = null): GetWebSocketTokenResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/profile/websocket_token",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetWebSocketTokenResponse::fromJson($json);
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
