<?php

namespace Pixxio\PixxioConnector\EventListener;

use Akeneo\Platform\Bundle\UIBundle\EventListener\ScriptNonceGenerator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class AddContentSecurityPolicyListener implements EventSubscriberInterface
{
    private string $generatedNonce;

    private bool $isUsed;

    public function __construct(ScriptNonceGenerator $nonceGenerator, bool $isUsed)
    {
        $this->isUsed = $isUsed;
        $this->generatedNonce = $nonceGenerator->getGeneratedNonce();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'addCspHeaders',
        ];
    }

    public function addCspHeaders(FilterResponseEvent $event): void
    {
        if ($this->isUsed) {
            // @codingStandardsIgnoreStart
            $policy = sprintf(
                "default-src 'self' *.akeneo.com *.pixxio.media *.px.media *.pixx.io fonts.googleapis.com 'unsafe-inline'; script-src 'self' localhost:* 127.0.0.1:* 'unsafe-eval' 'nonce-%s' 'unsafe-inline'; img-src 'self' *.pixxio.media *.px.media *.pixx.io data: ; frame-src * ; font-src 'self' fonts.gstatic.com fonts.googleapis.com data:",
                $this->generatedNonce
            );
            // @codingStandardsIgnoreEnd

            $response = $event->getResponse();
            $response->headers->set('Content-Security-Policy', $policy);
            $response->headers->set('X-Content-Security-Policy', $policy);
            $response->headers->set('X-WebKit-CSP', $policy);
        }
    }
}
