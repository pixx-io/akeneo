<?php

namespace Pixxio\PixxioConnector\AttributeType;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PixxioTypeTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testAttributeTypeIsRegisteredCorrect()
    {
        $attributeTypeRegistry = self::$container->get('pim_catalog.registry.attribute_type');

        $attributeType = $attributeTypeRegistry->get('pixxio_image');

        self::assertInstanceOf(PixxioType::class, $attributeType);
    }
}
