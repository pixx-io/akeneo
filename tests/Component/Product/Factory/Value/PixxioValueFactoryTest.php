<?php

namespace Flagbit\PixxioConnector\Component\Product\Factory\Value;

use Akeneo\Pim\Enrichment\Component\Product\Value\ScalarValue;
use Akeneo\Pim\Structure\Component\Query\PublicApi\AttributeType\Attribute;
use Akeneo\Tool\Component\StorageUtils\Exception\InvalidPropertyTypeException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PixxioValueFactoryTest extends KernelTestCase
{
    private static ?object $field;
    private static ?object $valueFactory;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$container;

        self::$field = $this->createAttribute(true, true);
        self::$valueFactory = $container->get('flagbit_pixxio.factory.value.field');
    }

    public function testCreateByCheckingData(): void
    {
        $result = self::$valueFactory->createByCheckingData(static::$field, 'channel', 'de_DE', 'data');
        $expected = ScalarValue::scopableLocalizableValue('code', 'data', 'channel', 'de_DE');

        self::assertEquals($expected, $result);
    }

    public function testCreateByCheckingDataException(): void
    {
        $this->expectException(InvalidPropertyTypeException::class);
        static::$valueFactory->createByCheckingData(self::$field, 'channel', 'de_DE', '');
    }

    public function testSupportedAttributeType(): void
    {
        self::assertSame(
            'pixxio_image',
            static::$valueFactory->supportedAttributeType()
        );
    }

    private function createAttribute(bool $isScopable, bool $isLocalizable): Attribute
    {
        return new Attribute(
            'code',
            'pixxio_image',
            [],
            $isLocalizable,
            $isScopable,
            null,
            null,
            false,
            'backend',
            ['de_DE', 'en_US']
        );
    }
}
