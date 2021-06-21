<?php

namespace Flagbit\PixxioConnector\Component\Product\Completeness\MaskItemGenerator;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PixxioMaskItemTest extends KernelTestCase
{
    private static ?object $item;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$container;

        static::$item = $container->get('flagbit.pixxio.mask_item');
    }

    public function testGetName()
    {
        self::assertEquals(['code-channel-locale'],
                           static::$item->forRawValue('code', 'channel', 'locale', 'value'));
    }

    public function testSupportedAttributeTypes()
    {
        self::assertEquals(['pixxio_image'],
                           static::$item->supportedAttributeTypes());
    }

}
