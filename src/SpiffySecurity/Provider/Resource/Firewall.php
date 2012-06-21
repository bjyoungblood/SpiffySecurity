<?php

namespace SpiffySecurity\Provider\Resource;

use Zend\ServiceManager\ServiceLocatorInterface;

class Firewall implements ProviderInterface
{
    public function __construct($firewalls)
    {
        $this->firewalls = $firewalls;
    }

    public function getResources()
    {
        $resourceNames = array();
        foreach ($this->firewalls as $i) {
            if (in_array($i->getResourceName(), $resourceNames)) {
                throw new \RuntimeException(sprintf(
                    'Resource name \'%s\' is not unique.',
                    $i->getResourceName()
                ));
            }

            $resourceNames[] = $i->getResourceName();
        }

        return $resourceNames;
    }
}
