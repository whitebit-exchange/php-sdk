<?php

namespace Whitebit\MarketFee\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;
use Whitebit\Core\Types\ArrayType;

class GetMarketFeeResponse extends JsonSerializableType
{
    /**
     * @var ?string $error
     */
    #[JsonProperty('error')]
    public ?string $error;

    /**
     * @var ?string $taker Taker fee percentage
     */
    #[JsonProperty('taker')]
    public ?string $taker;

    /**
     * @var ?string $maker Maker fee percentage
     */
    #[JsonProperty('maker')]
    public ?string $maker;

    /**
     * @var ?string $futuresTaker Default effective futures taker fee percentage. The system returns the lower value between the custom fee (if assigned) and the default market fee.
     */
    #[JsonProperty('futures_taker')]
    public ?string $futuresTaker;

    /**
     * @var ?string $futuresMaker Default effective futures maker fee percentage. The system returns the lower value between the custom fee (if assigned) and the default market fee.
     */
    #[JsonProperty('futures_maker')]
    public ?string $futuresMaker;

    /**
     * @var ?string $rpiMakerFeePremium Additional maker fee percentage applied on top of the `maker` rate when a [Retail Price Improvement (RPI)](/glossary#retail-price-improvement-rpi) order executes on a spot or margin market. The effective RPI maker rate equals `maker` plus `rpi_maker_fee_premium`. The field returns `null` when the RPI order mode is not enabled for the account or when no premium is configured.
     */
    #[JsonProperty('rpi_maker_fee_premium')]
    public ?string $rpiMakerFeePremium;

    /**
     * @var ?string $futuresRpiMakerFeePremium Additional maker fee percentage applied on top of the `futures_maker` rate when a [Retail Price Improvement (RPI)](/glossary#retail-price-improvement-rpi) order executes on a futures market. The effective futures RPI maker rate equals `futures_maker` plus `futures_rpi_maker_fee_premium`. The field returns `null` when the RPI order mode is not enabled for the account or when no premium is configured.
     */
    #[JsonProperty('futures_rpi_maker_fee_premium')]
    public ?string $futuresRpiMakerFeePremium;

    /**
     * @var ?array<string, GetMarketFeeResponseCustomFeeValue> $customFee Per-market fee overrides, keyed by market name. Each value contains the market's custom `taker` and `maker` rates.
     */
    #[JsonProperty('custom_fee'), ArrayType(['string' => GetMarketFeeResponseCustomFeeValue::class])]
    public ?array $customFee;

    /**
     * @param array{
     *   error?: ?string,
     *   taker?: ?string,
     *   maker?: ?string,
     *   futuresTaker?: ?string,
     *   futuresMaker?: ?string,
     *   rpiMakerFeePremium?: ?string,
     *   futuresRpiMakerFeePremium?: ?string,
     *   customFee?: ?array<string, GetMarketFeeResponseCustomFeeValue>,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->error = $values['error'] ?? null;
        $this->taker = $values['taker'] ?? null;
        $this->maker = $values['maker'] ?? null;
        $this->futuresTaker = $values['futuresTaker'] ?? null;
        $this->futuresMaker = $values['futuresMaker'] ?? null;
        $this->rpiMakerFeePremium = $values['rpiMakerFeePremium'] ?? null;
        $this->futuresRpiMakerFeePremium = $values['futuresRpiMakerFeePremium'] ?? null;
        $this->customFee = $values['customFee'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
