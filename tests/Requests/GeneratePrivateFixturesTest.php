<?php

use Saloon\Contracts\Request;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\WhiteBIT\BasicFixture;
use WhiteBIT\Sdk\DTO\InputLimitOrderDTO;
use WhiteBIT\Sdk\Enums\OrderTypeEnum;
use WhiteBIT\Sdk\Requests\Private\AddressRequest;
use WhiteBIT\Sdk\Requests\Private\Codes\ApplyCodeRequest;
use WhiteBIT\Sdk\Requests\Private\Codes\CodesHistoryRequest;
use WhiteBIT\Sdk\Requests\Private\Codes\CreateCodeRequest;
use WhiteBIT\Sdk\Requests\Private\Codes\MyCodesRequest;
use WhiteBIT\Sdk\Requests\Private\MainBalanceRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\DealsHistoryRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\OrderDealsRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\OrderHistoryRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\Orders\CancelOrderRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\Orders\CreateBulkLimitOrderRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\Orders\CreateLimitOrderRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\Orders\CreateMarketOrderRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\Orders\CreateStockMarketOrderRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\Orders\CreateStopLimitOrderRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\Spot\UnexecutedOrdersRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\StatusKillSwitchRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\SyncKillSwitchRequest;
use WhiteBIT\Sdk\Requests\Private\Trade\TradeBalanceRequest;

dataset('private_requests', [
    new MainBalanceRequest(),
    new AddressRequest('USDT', 'TRC20'),

    // Codes
    new MyCodesRequest(),
    new CodesHistoryRequest(),
    new CreateCodeRequest('USDT', '0.001'),
    new ApplyCodeRequest('WBfd853ed1-1610-4055-9ce3-990ae7ea7e86USDT'),

    // Trade
    new TradeBalanceRequest(),
    new OrderHistoryRequest(),
    new OrderDealsRequest('1234567890'),
    new DealsHistoryRequest(limit: 1),
    new UnexecutedOrdersRequest(limit: 1),

    // Trade - Spot
    new CreateLimitOrderRequest(
        'WBT_USDT',
        OrderTypeEnum::BUY,
        '10',
        '2'
    ),
    new CreateStopLimitOrderRequest(
        'WBT_USDT',
        OrderTypeEnum::BUY,
        '10',
        '2',
        '1'
    ),
    new CreateMarketOrderRequest(
        'WBT_USDT',
        OrderTypeEnum::BUY,
        '6'
    ),
    new CreateStockMarketOrderRequest(
        'WBT_USDT',
        OrderTypeEnum::BUY,
        '6'
    ),
    new CancelOrderRequest('WBT_USDT', '302788690962'),
    new CreateBulkLimitOrderRequest([
        new InputLimitOrderDTO(
            'WBT_USDT',
            OrderTypeEnum::BUY,
            '10',
            '2'
        ),
        new InputLimitOrderDTO(
            'WBT_USDT',
            OrderTypeEnum::BUY,
            '10',
            '2'
        ),
    ]),

    new SyncKillSwitchRequest(
        'WBT_USDT',
        '5',
        ['spot']
    ),
    new StatusKillSwitchRequest(),

]);

test('generate public fixtures', function (Request $request) {
    $mockClient = new MockClient([
        new BasicFixture(
            $request->resolveEndpoint()
        ),
    ]);

    $whitebit = createGuardedConnector();
    $whitebit->withMockClient($mockClient);

    $result = $whitebit->send($request);

    $this->assertTrue(true);
})->with('private_requests');
