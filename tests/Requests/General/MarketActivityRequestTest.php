<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\DTO\Response\MarketActivityDTO;
use WhiteBIT\Sdk\Requests\General\MarketActivityRequest;

it('calls correct endpoint', function () {
    $request = new MarketActivityRequest();

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/public/ticker')
        ->and($request->getMethod())
        ->toBe(Method::GET);
});

test('status code is correct', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/ticker'),
    ]));

    $result = $connector->send(new MarketActivityRequest());

    expect($result->status())
        ->toBe(200);
});

it('returns correct DTO response', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/ticker'),
    ]));

    $result = $connector->send(new MarketActivityRequest());

    $json = $result->json();
    $raw = array_shift($json);
    /** @var MarketActivityDTO $dto */
    $dto = $result->dto()[0];

    $this->assertTrue($dto instanceof MarketActivityDTO);

    expect($dto->market)
        ->toBe(array_keys($result->json())[0])
        ->and($dto->change)
        ->toBe($raw['change'])
        ->and($dto->baseId)
        ->toBe($raw['base_id'])
        ->and($dto->baseVolume)
        ->toBe($raw['base_volume'])
        ->and($dto->quoteId)
        ->toBe($raw['quote_id'])
        ->and($dto->quoteVolume)
        ->toBe($raw['quote_volume'])
        ->and($dto->isFrozen)
        ->toBe($raw['isFrozen'])
        ->and($dto->lastPrice)
        ->toBe($raw['last_price']);
});
