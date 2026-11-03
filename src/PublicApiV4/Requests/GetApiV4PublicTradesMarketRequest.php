<?php

namespace Whitebit\PublicApiV4\Requests;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\PublicApiV4\Types\GetApiV4PublicTradesMarketRequestType;

class GetApiV4PublicTradesMarketRequest extends JsonSerializableType
{
    /**
     * @var ?value-of<GetApiV4PublicTradesMarketRequestType> $type Filter by trade side. Omit to return both buy and sell trades.
     */
    public ?string $type;

    /**
     * @param array{
     *   type?: ?value-of<GetApiV4PublicTradesMarketRequestType>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->type = $values['type'] ?? null;
    }
}
