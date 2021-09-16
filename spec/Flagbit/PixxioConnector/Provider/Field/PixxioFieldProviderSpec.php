<?php

namespace spec\Pixxio\PixxioConnector\Provider\Field;

use Pixxio\PixxioConnector\Provider\Field\PixxioFieldProvider;
use PhpSpec\ObjectBehavior;
use Akeneo\Pim\Structure\Component\Model\AttributeInterface;


class PixxioFieldProviderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PixxioFieldProvider::class);
    }

    public function it_returns_pixxio_pixxio_field()
    {
        $element = [
            'foo' => 'bar',
        ];
        $this->getField($element)->shouldReturn('pixxio-image-field');
    }

    public function it_checks_correct_support
    (
        AttributeInterface $attributeInterface
    ) {
        $attributeInterface->getType()->willReturn('pixxio_image');
        $this->supports($attributeInterface)->shouldReturn(true);
    }

    public function it_checks_incorrect_support
    (
        AttributeInterface $attributeInterface
    ) {
        $attributeInterface->getType()->willReturn('foo_bar');
        $this->supports($attributeInterface)->shouldReturn(false);
    }
}
