<?php

namespace Whitebit\Traits;

use Whitebit\Core\Json\JsonProperty;

/**
 * @property int $id
 * @property mixed $error
 */
trait BaseResponse
{
    /**
     * @var int $id Request identifier matching the request
     */
    #[JsonProperty('id')]
    public int $id;

    /**
     * @var mixed $error
     */
    #[JsonProperty('error')]
    public mixed $error;
}
