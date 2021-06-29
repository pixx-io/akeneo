<?php

namespace Flagbit\PixxioConnector\Controller\InternalApi;

use Oro\Bundle\SecurityBundle\SecurityFacade;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class ConfigController
{
    private const ACL_EDIT_MODEL_ATTRIBUTES = 'pim_enrich_product_model_edit_attributes';
    private const ACL_EDIT_VARIANT_ATTRIBUTES = 'pim_enrich_product_edit_attributes';

    private static array $config = [];
    private SecurityFacade $securityFacade;

    public function __construct(
        SecurityFacade $securityFacade,
        ?string $configKey,
        ?string $configUrl,
        ?bool   $configVersion
    ) {
        $this->securityFacade = $securityFacade;

        static::$config = [
            'key' => $configKey ?? '',
            'url' => $configUrl ?? '',
            'version' => $configVersion ?? true
        ];
    }

    /**
     * @return JsonResponse|RedirectResponse
     */
    public function indexAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new RedirectResponse('/');
        }

        if (!$this->securityFacade->isGranted(static::ACL_EDIT_MODEL_ATTRIBUTES) &&
            !$this->securityFacade->isGranted(static::ACL_EDIT_VARIANT_ATTRIBUTES)
        ) {
            throw new AccessDeniedException();
        }

        return new JsonResponse(static::$config);
    }
}
