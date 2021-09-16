<?php

namespace spec\Pixxio\PixxioConnector\AttributeType;

use Pixxio\PixxioConnector\AttributeType\PixxioType;
use PhpSpec\ObjectBehavior;

class PixxioTypeSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('text');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(PixxioType::class);
    }

    public function it_returns_pixxio_image()
    {
        $this->getName()->shouldReturn('pixxio_image');
    }

    public function it_returns_text_forbackend_type()
    {
        $this->getBackendType()->shouldReturn('text');
    }
}
