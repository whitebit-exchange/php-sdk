<?php

namespace Whitebit\MarketFee;

use Psr\Http\Client\ClientInterface;
use Whitebit\Core\Client\RawClient;
use Whitebit\Environments;
use Whitebit\MarketFee\Requests\GetMarketFeeRequest;
use Whitebit\MarketFee\Types\GetMarketFeeResponse;
use Whitebit\Exceptions\WhitebitException;
use Whitebit\Exceptions\WhitebitApiException;
use Whitebit\Core\Json\JsonApiRequest;
use Whitebit\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;

class MarketFeeClient
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
     * Returns the account's default spot and futures maker and taker fees, plus any custom per-market overrides.
     *
     * The `maker` and `taker` fields represent default spot trading fees. The `futures_maker` and `futures_taker` fields represent default futures trading fees. The `custom_fee` object lists per-market overrides, keyed by market name.
     *
     * For accounts with the [Retail Price Improvement (RPI)](/glossary#retail-price-improvement-rpi) order mode enabled, the response returns non-null RPI maker fee premiums applied on top of the maker rates when RPI orders execute.
     *
     * The system calculates the effective futures fee as the lower value between the user-specific custom fee and the market-specific fee.
     *
     * When the market fee is lower than the assigned custom fee, the system returns the market fee.
     *
     * Example: If the custom futures taker fee equals `0.026` and the market fee equals `0.02`, the response returns `0.02`.
     *
     * @param GetMarketFeeRequest $request
     * @param ?array{
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return GetMarketFeeResponse
     * @throws WhitebitException
     * @throws WhitebitApiException
     */
    public function getMarketFee(GetMarketFeeRequest $request = new GetMarketFeeRequest(), ?array $options = null): GetMarketFeeResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->market != null) {
            $query['market'] = $request->market;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $this->environment->base,
                    path: "api/v4/market/fee",
                    method: HttpMethod::POST,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return GetMarketFeeResponse::fromJson($json);
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
