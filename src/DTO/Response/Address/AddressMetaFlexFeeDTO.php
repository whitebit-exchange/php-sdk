<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response\Address;

final class AddressMetaFlexFeeDTO
{
    public function __construct(
        public string $max,
        public string $min,
        public string $percent,
    ) {
    }

    public static function fromResponseJson(array $data): self
    {
        return new self(
            $data['maxFee'],
            $data['minFee'],
            $data['percent'],
        );
    }
}
