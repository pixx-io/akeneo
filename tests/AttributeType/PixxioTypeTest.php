<?php

namespace Flagbit\PixxioConnector\AttributeType;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PixxioTypeTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testGetName()
    {
        $container = self::$container;

        $attributeType = $container->get('flagbit.pixxio.attribute_type.image');

        self::assertEquals('pixxio_image', $attributeType->getName());
    }

    public function testAttributeTypeIsRegisteredCorrect()
    {
        $container = self::$container;

        $attributeTypeRegistry = $container->get('pim_catalog.registry.attribute_type');

        $attributeType = $attributeTypeRegistry->get('pixxio_image');

        self::assertInstanceOf(PixxioType::class, $attributeType);
    }
}
