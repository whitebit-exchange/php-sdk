<?php

namespace Whitebit\CollateralTrading\Types;

use Whitebit\Core\Json\JsonSerializableType;
use Exception;
use Whitebit\Core\Json\JsonDecoder;

class GetConditionalOrdersResponseRecordsItem extends JsonSerializableType
{
    /**
     * @var (
     *    'oco'
     *   |'oto'
     *   |'_unknown'
     * ) $type
     */
    public readonly string $type;

    /**
     * @var (
     *    GetConditionalOrdersResponseRecordsItemOco
     *   |GetConditionalOrdersResponseRecordsItemOto
     *   |mixed
     * ) $value
     */
    public readonly mixed $value;

    /**
     * @param array{
     *   type: (
     *    'oco'
     *   |'oto'
     *   |'_unknown'
     * ),
     *   value: (
     *    GetConditionalOrdersResponseRecordsItemOco
     *   |GetConditionalOrdersResponseRecordsItemOto
     *   |mixed
     * ),
     * } $values
     */
    private function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->value = $values['value'];
    }

    /**
     * @param GetConditionalOrdersResponseRecordsItemOco $oco
     * @return GetConditionalOrdersResponseRecordsItem
     */
    public static function oco(GetConditionalOrdersResponseRecordsItemOco $oco): GetConditionalOrdersResponseRecordsItem
    {
        return new GetConditionalOrdersResponseRecordsItem([
            'type' => 'oco',
            'value' => $oco,
        ]);
    }

    /**
     * @param GetConditionalOrdersResponseRecordsItemOto $oto
     * @return GetConditionalOrdersResponseRecordsItem
     */
    public static function oto(GetConditionalOrdersResponseRecordsItemOto $oto): GetConditionalOrdersResponseRecordsItem
    {
        return new GetConditionalOrdersResponseRecordsItem([
            'type' => 'oto',
            'value' => $oto,
        ]);
    }

    /**
     * @return bool
     */
    public function isOco(): bool
    {
        return $this->value instanceof GetConditionalOrdersResponseRecordsItemOco && $this->type === 'oco';
    }

    /**
     * @return GetConditionalOrdersResponseRecordsItemOco
     */
    public function asOco(): GetConditionalOrdersResponseRecordsItemOco
    {
        if (!($this->value instanceof GetConditionalOrdersResponseRecordsItemOco && $this->type === 'oco')) {
            throw new Exception(
                "Expected oco; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return bool
     */
    public function isOto(): bool
    {
        return $this->value instanceof GetConditionalOrdersResponseRecordsItemOto && $this->type === 'oto';
    }

    /**
     * @return GetConditionalOrdersResponseRecordsItemOto
     */
    public function asOto(): GetConditionalOrdersResponseRecordsItemOto
    {
        if (!($this->value instanceof GetConditionalOrdersResponseRecordsItemOto && $this->type === 'oto')) {
            throw new Exception(
                "Expected oto; got " . $this->type . " with value of type " . get_debug_type($this->value),
            );
        }

        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        $result = [];
        $result['type'] = $this->type;

        $base = parent::jsonSerialize();
        $result = array_merge($base, $result);

        switch ($this->type) {
            case 'oco':
                $value = $this->asOco()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case 'oto':
                $value = $this->asOto()->jsonSerialize();
                $result = array_merge($value, $result);
                break;
            case '_unknown':
            default:
                if (is_null($this->value)) {
                    break;
                }
                if ($this->value instanceof JsonSerializableType) {
                    $value = $this->value->jsonSerialize();
                    $result = array_merge($value, $result);
                } elseif (is_array($this->value)) {
                    $result = array_merge($this->value, $result);
                }
        }

        return $result;
    }

    /**
     * @param string $json
     */
    public static function fromJson(string $json): static
    {
        $decodedJson = JsonDecoder::decode($json);
        if (!is_array($decodedJson)) {
            throw new Exception("Unexpected non-array decoded type: " . gettype($decodedJson));
        }
        return self::jsonDeserialize($decodedJson);
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function jsonDeserialize(array $data): static
    {
        $args = [];
        if (!array_key_exists('type', $data)) {
            throw new Exception(
                "JSON data is missing property 'type'",
            );
        }
        $type = $data['type'];
        if (!(is_string($type))) {
            throw new Exception(
                "Expected property 'type' in JSON data to be string, instead received " . get_debug_type($data['type']),
            );
        }

        $args['type'] = $type;
        switch ($type) {
            case 'oco':
                $args['value'] = GetConditionalOrdersResponseRecordsItemOco::jsonDeserialize($data);
                break;
            case 'oto':
                $args['value'] = GetConditionalOrdersResponseRecordsItemOto::jsonDeserialize($data);
                break;
            case '_unknown':
            default:
                $args['type'] = '_unknown';
                $args['value'] = $data;
        }

        // @phpstan-ignore-next-line
        return new static($args);
    }
}
