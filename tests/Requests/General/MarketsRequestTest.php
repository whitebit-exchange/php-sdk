<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\DTO\Response\MarketDTO;
use WhiteBIT\Sdk\Requests\General\MarketsRequest;

it('calls correct endpoint', function () {
    $request = new MarketsRequest();

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/public/markets')
        ->and($request->getMethod())
        ->toBe(Method::GET);
});

test('status code is correct', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/markets'),
    ]));

    $result = $connector->send(new MarketsRequest());

    expect($result->status())
        ->toBe(200);
});

it('returns correct DTO response', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/markets'),
    ]));

    $result = $connector->send(new MarketsRequest());

    $json = $result->json();
    $raw = array_shift($json);
    /** @var MarketDTO $dto */
    $dto = $result->dto()[0];

    $this->assertTrue($dto instanceof MarketDTO);

    expect($dto->name)
        ->toBe($raw['name'])
        ->and($dto->makerFee)
        ->toBe($raw['makerFee'])
        ->and($dto->takerFee)
        ->toBe($raw['takerFee'])
        ->and((string) $dto->feePrecision)
        ->toBe($raw['feePrec'])
        ->and((string) $dto->moneyPrecision)
        ->toBe($raw['moneyPrec'])
        ->and((string) $dto->stockPrecision)
        ->toBe($raw['stockPrec'])
        ->and($dto->minAmount)
        ->toBe($raw['minAmount'])
        ->and($dto->minTotal)
        ->toBe($raw['minTotal'])
        ->and($dto->maxTotal)
        ->toBe($raw['maxTotal'])
        ->and($dto->tradesEnabled)
        ->toBe($raw['tradesEnabled'])
        ->and($dto->isCollateral)
        ->toBe($raw['isCollateral'])
        ->and($dto->type->value)
        ->toBe($raw['type']);

});
