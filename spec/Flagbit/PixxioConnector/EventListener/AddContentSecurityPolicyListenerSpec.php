<?php

namespace spec\Flagbit\PixxioConnector\EventListener;

use Akeneo\Platform\Bundle\UIBundle\EventListener\ScriptNonceGenerator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AddContentSecurityPolicyListenerSpec extends ObjectBehavior
{
    function let(ScriptNonceGenerator $scriptNonceGenerator)
    {
        $scriptNonceGenerator->getGeneratedNonce()->willReturn('generated_nonce');
        $this->beConstructedWith($scriptNonceGenerator);
    }

    function it_subscribes_to_kernel_response()
    {
        $this->getSubscribedEvents()->shouldReturn([KernelEvents::RESPONSE => 'addCspHeaders']);
    }

    function it_returns_extended_csp(FilterResponseEvent $event, Response $response, ResponseHeaderBag $responseHeader)
    {
        $responseHeader->set(
            Argument::any(),
            Argument::any(),
            Argument::any()
        )
            ->shouldBeCalledTimes(3)
            ->withArguments(
                    [Argument::type('string'), $this->getExpected()]
            )
        ;
        $response->headers = $responseHeader;
        $event->getResponse()->willReturn($response);
        $this->addCspHeaders($event);
    }

    private function getExpected(): string
    {
        return sprintf(
            "default-src 'self' *.akeneo.com *.pixxio.media fonts.googleapis.com 'unsafe-inline'; script-src 'self' localhost:* 127.0.0.1:* 'unsafe-eval' 'nonce-%s' 'unsafe-inline'; img-src 'self' *.pixxio.media data: ; frame-src * ; font-src 'self' fonts.gstatic.com fonts.googleapis.com data:",
            'generated_nonce'
        );
    }
}
