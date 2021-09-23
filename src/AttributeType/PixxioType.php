<?php

namespace Pixxio\PixxioConnector\AttributeType;

use Akeneo\Pim\Structure\Component\AttributeType\AbstractAttributeType;

class PixxioType extends AbstractAttributeType
{
    public const PIXXIO_IMAGE = 'pixxio_image';

    public function getName()
    {
        return self::PIXXIO_IMAGE;
    }
}
