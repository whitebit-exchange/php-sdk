<?php

use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\DTO\Response\TradeItemDTO;
use WhiteBIT\Sdk\Requests\General\TradesRequest;

it('calls correct endpoint', function () {
    $request = new TradesRequest('BTC_USDT');

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/public/trades/BTC_USDT')
        ->and($request->getMethod())
        ->toBe(Method::GET);
});

test('status code is correct', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/public/trades/BTC_USDT'),
    ]));

    $result = $connector->send(new TradesRequest('BTC_USDT'));

    expect($result->status())
        ->toBe(200);
});

it('returns correct DTO response', function () {
    $connector = new WhiteBITConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/public/trades'),
    ]));

    $result = $connector->send(new TradesRequest('BTC_USDT'));

    $json = $result->json();
    $raw = array_shift($json);
    /** @var TradeItemDTO $dto */
    $dto = $result->dto()[0];

    $this->assertTrue($dto instanceof TradeItemDTO);

    expect($dto->tradeId)
        ->toBe($raw['tradeID'])
        ->and($dto->price)
        ->toBe($raw['price'])
        ->and($dto->quoteVolume)
        ->toBe($raw['quote_volume'])
        ->and($dto->baseVolume)
        ->toBe($raw['base_volume'])
        ->and($dto->tradedAt->getTimestamp())
        ->toBe($raw['trade_timestamp'])
        ->and($dto->type->value)
        ->toBe($raw['type']);
});
