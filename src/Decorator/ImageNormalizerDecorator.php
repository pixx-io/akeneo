<?php

declare(strict_types=1);

namespace Flagbit\PixxioConnector\Decorator;

use Akeneo\Pim\Enrichment\Component\Product\Model\ValueInterface;
use Akeneo\Pim\Enrichment\Component\Product\Normalizer\InternalApi\ImageNormalizer;
use Akeneo\Pim\Enrichment\Component\Product\Value\ScalarValue;

final class ImageNormalizerDecorator extends ImageNormalizer
{
    private ?ImageNormalizer $imageNormalizer = null;

    public function __construct(ImageNormalizer $imageNormalizer)
    {
        $this->imageNormalizer = $imageNormalizer;
    }

    public function normalize(?ValueInterface $value, ?string $localeCode = null, ?string $channelCode = null): ?array
    {
        $metaImage = null;

        if (!$value instanceof ScalarValue) {
            $metaImage = $this->imageNormalizer->normalize($value, $localeCode, $channelCode);
        }

        if (null !== $metaImage) {
            return $metaImage;
        }

        if (null !== $value && $this->isUrl($value->getData())) {
            return  [
                'filePath'         => $value->getData(),
                'originalFilename' => 'Pixxio Image',
            ];
        }

        return null;
    }

    protected function isUrl($data): bool
    {
        return !empty($data) && is_string($data) && \str_starts_with($data, 'http');
    }
}
