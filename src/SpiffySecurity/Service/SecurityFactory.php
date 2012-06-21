<?php

namespace SpiffySecurity\Service;

use InvalidArgumentException;
use RuntimeException;
use SpiffySecurity\Service\Security;
use Zend\Acl\Acl;
use Zend\Acl\Role\RoleInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SecurityFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sl)
    {
        $config = $sl->get('Configuration');
        $config = $config['security'];

        $security = new Security($config);
        $options  = $security->options();

        foreach($options->getRoleProviders() as $class => $config) {
            $security->addRoleProvider($class::factory($sl, $config));
        }

        foreach($options->getResourceProviders() as $class => $config) {
            $security->addResourceProvider(new $class($config, $security));
        }

        foreach($options->getFirewalls() as $class => $config) {
            $security->addFirewall(new $class($config, $security));
        }

        $identity = $security->options()->getIdentityProvider();
        if (!$sl->has($identity)) {
            throw new RuntimeException(sprintf(
                'An identity provider with the name "%s" does not exist',
                $identity
            ));
        }

        $security->setIdentity($sl->get($identity));

        return $security;
    }
}
