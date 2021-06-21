<?php

namespace spec\Flagbit\PixxioConnector\Component\Product\Completeness\MaskItemGenerator;

use Flagbit\PixxioConnector\Component\Product\Completeness\MaskItemGenerator\PixxioMaskItem;
use PhpSpec\ObjectBehavior;

class PixxioMaskItemSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(PixxioMaskItem::class);
    }

    public function it_masks_for_raw_value()
    {
        $this->forRawValue('a', 'b', 'c', 'd')->shouldBe(['a-b-c']);
    }

    public function it_supports_attribute_types()
    {
        $this->supportedAttributeTypes()->shouldBe(['pixxio_image']);
    }
}
