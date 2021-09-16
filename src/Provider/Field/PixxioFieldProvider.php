<?php

namespace Pixxio\PixxioConnector\Provider\Field;

use Akeneo\Platform\Bundle\UIBundle\Provider\Field\FieldProviderInterface;
use Akeneo\Pim\Structure\Component\Model\AttributeInterface;
use Pixxio\PixxioConnector\AttributeType\PixxioType;

class PixxioFieldProvider implements FieldProviderInterface
{
    private const PIXXIO_FIELD = 'pixxio-image-field';

    public function getField($element)
    {
        return self::PIXXIO_FIELD;
    }

    public function supports($element)
    {
        return $element instanceof AttributeInterface && PixxioType::PIXXIO_IMAGE === $element->getType();
    }
}
