<?php

namespace CPASimUSante\ItemSelectorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use CPASimUSante\ItemSelectorBundle\Entity\ItemSelector;
use Claroline\CoreBundle\Library\Resource\ResourceCollection;

class Controller extends BaseController
{
    /**
     * @param string   $permission
     * @param ItemSelector $itemSelector
     *
     * @throws AccessDeniedException
     */
    protected function checkAccess($permission, ItemSelector $itemSelector)
    {
        $collection = new ResourceCollection(array($itemSelector->getResourceNode()));
        if (!$this->get('security.authorization_checker')->isGranted($permission, $collection)) {
            throw new AccessDeniedException($collection->getErrorsForDisplay());
        }
    }

    /**
     * @param string   $permission
     * @param ItemSelector $itemSelector
     *
     * @return bool
     */
    protected function isUserGranted($permission, ItemSelector $itemSelector, $collection = null)
    {
        if ($collection === null) {
            $collection = new ResourceCollection(array($itemSelector->getResourceNode()));
        }
        $checkPermission = false;
        if ($this->get('security.authorization_checker')->isGranted($permission, $collection)) {
            $checkPermission = true;
        }

        return $checkPermission;
    }
}
