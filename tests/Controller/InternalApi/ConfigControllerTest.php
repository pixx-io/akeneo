<?php

namespace Flagbit\PixxioConnector\Controller\ConfigController;

use Flagbit\PixxioConnector\Controller\InternalApi\ConfigController;
use Oro\Bundle\SecurityBundle\SecurityFacade;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ConfigControllerTest extends KernelTestCase
{
    public function testIndexAction()
    {
        $request = $this->getRequestMock(true);

        $controller = new ConfigController($this->getSecurityFacadeMock([true, true]), 'key', 'url', true);

        $actual = $controller->indexAction($request);
        self::assertEquals(
            new JsonResponse(
                [
                    'key' => 'key',
                    'url' => 'url',
                    'version' => true
                ]
            ), $actual);
    }

    public function testIndexActionAclException()
    {
        $request = $this->getRequestMock(true);

        $controller = new ConfigController($this->getSecurityFacadeMock([false, false]), 'key', 'url', true);
        $this->expectException(AccessDeniedException::class);
        $controller->indexAction($request);
    }

    public function testIndexActionRedirect()
    {
        $request = $this->getRequestMock(false);

        $controller = new ConfigController($this->getSecurityFacadeMock([false, true]), 'key', 'url', true);

        $actual = $controller->indexAction($request);

        $resp = new RedirectResponse('/');

        self::assertEquals($resp->getStatusCode(), $actual->getStatusCode());
        self::assertEquals($resp->getTargetUrl(), $actual->getTargetUrl());
    }

    private function getRequestMock(bool $expected)
    {
        $requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $requestMock->expects(self::exactly(1))
            ->method('isXmlHttpRequest')
            ->willReturn($expected);

        return $requestMock;
    }

    private function getSecurityFacadeMock(array $result)
    {
        $securityMock = $this->getMockBuilder(SecurityFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $securityMock
            ->method('isGranted')
            ->willReturnOnConsecutiveCalls(...$result);

        return $securityMock;
    }
}
