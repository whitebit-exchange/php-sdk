<?php

use Illuminate\Support\Collection;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\DTO\Response\Private\Trade\TradeBalanceDTO;
use WhiteBIT\Sdk\Requests\Private\Trade\TradeBalanceRequest;

it('calls correct endpoint', function () {
    $request = new TradeBalanceRequest('BTC_USDT');

    expect($request->resolveEndpoint())
        ->toBe('/api/v4/trade-account/balance')
        ->and($request->getMethod())
        ->toBe(Method::POST)
        ->and($request->body()->all())
        ->toBe([
            'ticker' => 'BTC_USDT',
        ]);
});

it('returns correct DTO response', function () {
    $connector = createGuardedConnector();
    $request = new TradeBalanceRequest();

    $connector->withMockClient(new MockClient([
        new BasicFixture($request->resolveEndpoint()),
    ]));

    $result = $connector->send($request);

    $json = $result->json();
    $raw = array_values($json)[0];

    /** @var Collection $collection */
    $collection = $result->dto();

    /** @var TradeBalanceDTO $firstItem */
    $firstItem = $collection->first();

    expect($collection)
        ->toBeInstanceOf(Collection::class)
        ->and($firstItem)
        ->toBeInstanceOf(TradeBalanceDTO::class)
        ->and($firstItem->available)
        ->toBe($raw['available'])
        ->and($firstItem->freeze)
        ->toBe($raw['freeze'])
        ->and($firstItem->ticker)
        ->toBe(array_keys($json)[0]);
});

test('status code is correct', function () {
    $connector = createGuardedConnector();

    $connector->withMockClient(new MockClient([
        new BasicFixture('/api/v4/trade-account/balance'),
    ]));

    $result = $connector->send(new TradeBalanceRequest());

    expect($result->status())
        ->toBe(200);
});
