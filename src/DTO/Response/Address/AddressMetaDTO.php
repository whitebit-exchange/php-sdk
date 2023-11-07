<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response\Address;

final class AddressMetaDTO
{
    public function __construct(
        public string $fixedFee,
        public string $maxAmount,
        public string $minAmount,
        public AddressMetaFlexFeeDTO $flexFee,
    ) {
    }

    public static function fromResponseJson(array $data): self
    {
        return new self(
            $data['fixedFee'],
            $data['maxAmount'],
            $data['minAmount'],
            AddressMetaFlexFeeDTO::fromResponseJson($data['flexFee']),
        );
    }
}
