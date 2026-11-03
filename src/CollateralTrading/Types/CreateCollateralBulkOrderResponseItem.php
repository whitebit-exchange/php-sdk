<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Whitebit\Core\Json\JsonProperty;

class CreateCollateralBulkOrderResponseItem extends JsonSerializableType
{
    /**
     * @var ?CreateCollateralBulkOrderResponseItemResult $result Order data when successful, null when failed
     */
    #[JsonProperty('result')]
    public ?CreateCollateralBulkOrderResponseItemResult $result;

    /**
     * @var ?CreateCollateralBulkOrderResponseItemError $error Error details when order creation failed, null when successful
     */
    #[JsonProperty('error')]
    public ?CreateCollateralBulkOrderResponseItemError $error;

    /**
     * @param array{
     *   result?: ?CreateCollateralBulkOrderResponseItemResult,
     *   error?: ?CreateCollateralBulkOrderResponseItemError,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->result = $values['result'] ?? null;
        $this->error = $values['error'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
