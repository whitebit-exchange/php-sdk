<?php

namespace Whitebit\Traits;

use Whitebit\Core\Json\JsonProperty;

/**
 * @property int $id
 */
trait BaseRequest
{
    /**
     * @var int $id Unique request identifier
     */
    #[JsonProperty('id')]
    public int $id;
}
