<?php

namespace Flagbit\PixxioConnector\Decorator;

use Akeneo\Pim\Enrichment\Component\Product\Model\ValueInterface;
use Akeneo\Pim\Enrichment\Component\Product\Normalizer\InternalApi\ImageNormalizer;
use Akeneo\Pim\Enrichment\Component\Product\Value\OptionsValue;
use Akeneo\Pim\Enrichment\Component\Product\Value\ScalarValue;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ImageNormalizerDecoratorTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testWillDecorate()
    {
        $normalizer = static::$container->get('pim_enrich.normalizer.image');
        $this->assertEquals(ImageNormalizerDecorator::class, \get_class($normalizer));
    }
}
