<?php

declare(strict_types=1);

namespace spec\Flagbit\PixxioConnector\Decorator;

use Akeneo\Pim\Enrichment\Component\Product\Normalizer\InternalApi\ImageNormalizer;
use Akeneo\Pim\Enrichment\Component\Product\Value\MediaValueInterface;
use Akeneo\Pim\Enrichment\Component\Product\Value\ScalarValue;
use Akeneo\Tool\Component\FileStorage\Model\FileInfoInterface;
use Flagbit\PixxioConnector\Decorator\ImageNormalizerDecorator;
use PhpSpec\ObjectBehavior;

class ImageNormalizerDecoratorSpec extends ObjectBehavior
{
    public function let(ImageNormalizer $normalizer)
    {
        $this->beConstructedWith($normalizer);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ImageNormalizerDecorator::class);
    }

    public function it_is_imageNormalizer()
    {
        $this->shouldBeAnInstanceOf(ImageNormalizer::class);
    }

    public function it_will_not_normalize_no_url()
    {
        $this->normalize(ScalarValue::value('code', 'ht/example.com'))->shouldBeNull();
    }

    public function it_normalizes_url()
    {
        $this->normalize(
            ScalarValue::value('code', 'https://example.com')
        )->shouldBe(
            [
                'filePath'         => 'https://example.com',
                'originalFilename' => 'Pixxio Image',
            ]
        );
    }

    public function it_normalizes_default_value(MediaValueInterface $mediaValue, FileInfoInterface $fileInfo, ImageNormalizer $normalizer)
    {
        $mediaValue->getData()->willReturn($fileInfo);

        $expected = [
            'filePath'         => 'test',
            'originalFilename' => 'filename',
        ];

        $normalizer->normalize($mediaValue, null,null)->willReturn($expected);

        $this->normalize($mediaValue)->shouldBe($expected);
    }
}
