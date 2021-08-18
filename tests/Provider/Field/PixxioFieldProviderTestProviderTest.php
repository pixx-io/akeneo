<?php

namespace Flagbit\PixxioConnector\Test\Provider\Field;

use Akeneo\Pim\Structure\Component\Model\Attribute;
use Flagbit\PixxioConnector\AttributeType\PixxioType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PixxioFieldProviderTest extends KernelTestCase
{
    public function testFieldProviderIsCompatible()
    {
        self::bootKernel();
        $container = self::$container;

        $chainedFieldProvider = $container->get('pim_enrich.provider.field.chained');

        $attribute = new Attribute();
        $attribute->setAttributeType(PixxioType::PIXXIO_IMAGE);

        $fieldProvider = $chainedFieldProvider->getField($attribute);

        self::assertSame('pixxio-image-field', $fieldProvider);
    }
}
