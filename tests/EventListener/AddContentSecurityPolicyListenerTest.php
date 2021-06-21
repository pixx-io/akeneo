<?php

namespace Flagbit\PixxioConnector\EventListener;

use Akeneo\Platform\Bundle\UIBundle\EventListener\ScriptNonceGenerator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AddContentSecurityPolicyListenerTest extends KernelTestCase
{
    /**
     * @var \Symfony\Component\HttpFoundation\Response
     */
    private Response $responseClass;

    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testAddCspHeaders()
    {
        $cspListener = new AddContentSecurityPolicyListener($this->getSecurityMock());

        $mock = $this->getFilterResponseMock();
        $cspListener->addCspHeaders($mock);
    }

    public function testGetSubscribedEvents()
    {
        $actual = AddContentSecurityPolicyListener::getSubscribedEvents();
        $this->assertEquals([KernelEvents::RESPONSE => 'addCspHeaders'], $actual);
    }

    private function getFilterResponseMock()
    {
        $expected = "default-src 'self' *.akeneo.com *.pixxio.media fonts.googleapis.com 'unsafe-inline'; script-src 'self' localhost:* 127.0.0.1:* 'unsafe-eval' 'nonce-asdf' 'unsafe-inline'; img-src 'self' *.pixxio.media data: ; frame-src * ; font-src 'self' fonts.gstatic.com fonts.googleapis.com data:";

        $this->responseClass = new Response();

        $responseHeaderMock = $this->getMockBuilder(ResponseHeaderBag::class)
            ->disableOriginalConstructor()
            ->getMock();

        $responseHeaderMock->expects(self::exactly(3))
            ->method('set')
            ->withConsecutive(
                ['Content-Security-Policy', $expected],
                ['X-Content-Security-Policy', $expected],
                ['X-WebKit-CSP', $expected],
            );

        $this->responseClass->headers = $responseHeaderMock;
        $mock = $this->getMockBuilder(FilterResponseEvent::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects(self::exactly(1))
            ->method('getResponse')
            ->willReturn($this->responseClass);

        return $mock;
    }

    private function getSecurityMock()
    {
        $mock = $this->getMockBuilder(ScriptNonceGenerator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects(self::exactly(1))
            ->method('getGeneratedNonce')
            ->willReturn('asdf');

        return $mock;
    }
}
