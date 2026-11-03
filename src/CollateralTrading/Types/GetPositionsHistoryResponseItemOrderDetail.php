<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

/**
 * Details of order which changes position
 */
class GetPositionsHistoryResponseItemOrderDetail extends JsonSerializableType
{
    /**
     * @var ?int $id Order identifier
     */
    #[JsonProperty('id')]
    public ?int $id;

    /**
     * @var ?string $tradeAmount Trade amount of order
     */
    #[JsonProperty('tradeAmount')]
    public ?string $tradeAmount;

    /**
     * @var ?string $price Order price
     */
    #[JsonProperty('price')]
    public ?string $price;

    /**
     * @var ?string $tradeFee Order trade fee
     */
    #[JsonProperty('tradeFee')]
    public ?string $tradeFee;

    /**
     * @var ?string $fundingFee Funding fee captured by this position change
     */
    #[JsonProperty('fundingFee')]
    public ?string $fundingFee;

    /**
     * @var ?string $realizedPnl Realized profit and loss
     */
    #[JsonProperty('realizedPnl')]
    public ?string $realizedPnl;

    /**
     * @param array{
     *   id?: ?int,
     *   tradeAmount?: ?string,
     *   price?: ?string,
     *   tradeFee?: ?string,
     *   fundingFee?: ?string,
     *   realizedPnl?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->id = $values['id'] ?? null;
        $this->tradeAmount = $values['tradeAmount'] ?? null;
        $this->price = $values['price'] ?? null;
        $this->tradeFee = $values['tradeFee'] ?? null;
        $this->fundingFee = $values['fundingFee'] ?? null;
        $this->realizedPnl = $values['realizedPnl'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
