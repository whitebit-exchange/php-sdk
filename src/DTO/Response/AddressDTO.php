<?php

declare(strict_types=1);

namespace WhiteBIT\Sdk\DTO\Response;

use WhiteBIT\Sdk\DTO\Response\Address\AddressMetaDTO;

final class AddressDTO
{
    public function __construct(
        public string $address,
        public AddressMetaDTO $meta,
        public ?string $memo = null
    ) {
    }

    public static function fromResponseJson(array $data): self
    {
        return new self(
            $data['account']['address'],
            AddressMetaDTO::fromResponseJson($data['required']),
            $data['account']['memo'] ?? null
        );
    }
}
