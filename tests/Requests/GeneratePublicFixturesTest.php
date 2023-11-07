<?php

use Saloon\Contracts\Request;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\Connectors\WhiteBITConnector;
use WhiteBIT\Sdk\Requests\General\AssetsRequest;
use WhiteBIT\Sdk\Requests\General\CollateralMarketsRequest;
use WhiteBIT\Sdk\Requests\General\FeeRequest;
use WhiteBIT\Sdk\Requests\General\FutureMarketsRequest;
use WhiteBIT\Sdk\Requests\General\HealthRequest;
use WhiteBIT\Sdk\Requests\General\MarketActivityRequest;
use WhiteBIT\Sdk\Requests\General\MarketsRequest;
use WhiteBIT\Sdk\Requests\General\OrderBookRequest;
use WhiteBIT\Sdk\Requests\General\TradesRequest;

dataset('public_requests', [
    new AssetsRequest(),
    new FeeRequest(),
    new CollateralMarketsRequest(),
    new FutureMarketsRequest(),
    new HealthRequest(),
    new MarketActivityRequest(),
    new MarketsRequest(),
    new OrderBookRequest('BTC_USDT'),
    new TradesRequest('BTC_USDT'),
]);

test('generate public fixtures', function (Request $request) {
    $mockClient = new MockClient([
        new BasicFixture(
            $request->resolveEndpoint()
        ),
    ]);

    $whitebit = new WhiteBITConnector();
    $whitebit->withMockClient($mockClient);

    $whitebit->send($request);

    $this->assertTrue(true);
})->with('public_requests');
