<?php

namespace SpiffySecurity\Provider\Resource;

use Zend\ServiceManager\ServiceLocatorInterface;

class Firewall implements ProviderInterface
{
    public function __construct(array $options = array(), $security)
    {
        $this->security = $security;
    }

    public function getResources()
    {
        $firewalls = $this->security->getFirewalls();

        $resourceNames = array();
        foreach ($firewalls as $i) {
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
