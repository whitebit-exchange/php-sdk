<?php

namespace Whitebit\TravelRule;

use Psr\Http\Client\ClientInterface;
use Whitebit\Core\Client\RawClient;
use Whitebit\Environments;
use Whitebit\TravelRule\Requests\GetTravelRuleVaspsRequest;
use Whitebit\TravelRule\Types\GetTravelRuleVaspsResponse;
use Whitebit\Exceptions\WhitebitException;
use Whitebit\Exceptions\WhitebitApiException;
use Whitebit\Core\Json\JsonApiRequest;
use Whitebit\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Whitebit\TravelRule\Requests\TravelRuleDepositVerificationRequest;
use Whitebit\TravelRule\Types\SubmitTravelRuleDepositVerificationResponse;

class TravelRuleClient
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
     * Retrieves the list of Virtual Asset Service Providers (VASPs) that can be used when submitting travel rule data for deposits and withdrawals.
     *
     * Use the returned `vaspId` when submitting travel rule data if the destination/originating VASP is in this list. If the VASP is not in the list, use `vaspName` as a fallback.
     *
     * <Accordion title="Errors">
     * **API disabled for region (422):**
     * ```json
     * {
     *   "code": 0,
     *   "message": "Something went wrong",
     *   "errors": {
     *     "error": ["This endpoint is disabled for your region"]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * Beyond the errors above, this endpoint can return only the [common authentication errors](/api-reference/authentication).
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * @param GetTravelRuleVaspsRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetTravelRuleVaspsResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getTravelRuleVasps(GetTravelRuleVaspsRequest $request, ?array $options = null): GetTravelRuleVaspsResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/travel-rule/vasps",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetTravelRuleVaspsResponse::fromJson($json);
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
     * Submits originator information for a deposit that is ready for the travel rule verification.
     *
     * **Wallet types:**
     * - `hosted` - VASP-hosted wallet (exchange, custodian). Requires `vaspData` object.
     * - `unhosted` - Self-custody wallet (hardware wallet, software wallet). No VASP required.
     *
     * **Party types:**
     * - `individual` - Natural person. Requires `firstName` and `lastName`.
     * - `entity` - Legal entity. Requires `fullName`.
     *
     * <Accordion title="Errors">
     * **Validation failed (400):**
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "originator.firstName": ["The first name field is required for individual."],
     *     "originator.address": ["The originator address field is required."]
     *   }
     * }
     * ```
     *
     * **Transaction not found (422):**
     * ```json
     * {
     *   "code": 0,
     *   "message": "Something went wrong",
     *   "errors": {
     *     "uniqueId": ["Transaction not found"]
     *   }
     * }
     * ```
     *
     * **Transaction must be deposit (422):**
     * ```json
     * {
     *   "code": 0,
     *   "message": "Something went wrong",
     *   "errors": {
     *     "uniqueId": ["Transaction must be a deposit"]
     *   }
     * }
     * ```
     *
     * **Transaction not ready for verification (422):**
     * ```json
     * {
     *   "code": 0,
     *   "message": "Something went wrong",
     *   "errors": {
     *     "uniqueId": ["Transaction is not ready for verification"]
     *   }
     * }
     * ```
     *
     * **API disabled for region (422):**
     * ```json
     * {
     *   "code": 0,
     *   "message": "Something went wrong",
     *   "errors": {
     *     "error": ["This endpoint is disabled for your region"]
     *   }
     * }
     * ```
     *
     * **Missing VASP for hosted wallet (400):**
     * ```json
     * {
     *   "code": 0,
     *   "message": "Validation failed",
     *   "errors": {
     *     "vaspData": ["Either vaspId or vaspName is required for hosted wallets"]
     *   }
     * }
     * ```
     * </Accordion>
     *
     * Beyond the errors above, this endpoint can return only the [common authentication errors](/api-reference/authentication).
     *
     * <Warning>
     * Rate limit: 1000 requests/10 sec.
     * </Warning>
     *
     * <Note>
     * The API does not cache the response.
     * </Note>
     *
     * @param TravelRuleDepositVerificationRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return SubmitTravelRuleDepositVerificationResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function submitTravelRuleDepositVerification(TravelRuleDepositVerificationRequest $request, ?array $options = null): SubmitTravelRuleDepositVerificationResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/travel-rule/deposit/verification",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return SubmitTravelRuleDepositVerificationResponse::fromJson($json);
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
