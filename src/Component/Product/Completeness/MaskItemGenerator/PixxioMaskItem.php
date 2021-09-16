<?php

namespace Pixxio\PixxioConnector\Component\Product\Completeness\MaskItemGenerator;

use Akeneo\Pim\Enrichment\Component\Product\Completeness\MaskItemGenerator\MaskItemGeneratorForAttributeType;
use Pixxio\PixxioConnector\AttributeType\PixxioType;

class PixxioMaskItem implements MaskItemGeneratorForAttributeType
{
    public function forRawValue(string $attributeCode, string $channelCode, string $localeCode, $value): array
    {
        return [
            sprintf(
                '%s-%s-%s',
                $attributeCode,
                $channelCode,
                $localeCode
            )
        ];
    }

    public function supportedAttributeTypes(): array
    {
        return [
            PixxioType::PIXXIO_IMAGE,
        ];
    }
}
