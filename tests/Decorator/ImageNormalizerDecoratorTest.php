<?php

namespace Flagbit\PixxioConnector\Decorator;

use Akeneo\Pim\Enrichment\Component\Product\Model\ValueInterface;
use Akeneo\Pim\Enrichment\Component\Product\Normalizer\InternalApi\ImageNormalizer;
use Akeneo\Pim\Enrichment\Component\Product\Value\OptionsValue;
use Akeneo\Pim\Enrichment\Component\Product\Value\ScalarValue;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ImageNormalizerDecoratorTest extends KernelTestCase
{
    private static array  $defaultReturn = [
        'filePath'         => 'path',
        'originalFilename' => 'Some name',
    ];

    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testNormalize()
    {
        $decorator = new ImageNormalizerDecorator($this->getImageNormalizerMock());
        $actual = $decorator->normalize(ScalarValue::value('code', 'http://example.com'));

        $this->assertEquals(['filePath' => 'http://example.com', 'originalFilename' => 'Pixxio Image'], $actual);
    }

    public function testNormalizeNoUrl()
    {
        $decorator = new ImageNormalizerDecorator($this->getImageNormalizerMock());
        $actual = $decorator->normalize(ScalarValue::value('code', 'data'));

        $this->assertNull($actual);
    }

    public function testNormalizeDefault()
    {
        $decorator = new ImageNormalizerDecorator($this->getImageNormalizerMock());
        $actual = $decorator->normalize(OptionsValue::value('code', ['data']));

        $this->assertEquals(static::$defaultReturn, $actual);
    }

    private function getImageNormalizerMock()
    {
        $requestMock = $this->getMockBuilder(ImageNormalizer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $requestMock
            ->method('normalize')
            ->willReturn(static::$defaultReturn);

        return $requestMock;
    }
}
