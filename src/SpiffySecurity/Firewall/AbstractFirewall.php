<?php

namespace SpiffySecurity\Firewall;

use SpiffySecurity\Identity\IdentityInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Acl\Acl;

abstract class AbstractFirewall
{
    /**
     * Get the firewall name.
     *
     * @abstract
     * @return string
     */
    abstract public function getName();

    /**
     * Checks if access is granted to resource for the role.
     *
     * @abstract
     * @param \SpiffySecurity\Identity\IdentityInterface $identity
     * @param string $resource
     * @return bool
     */
    abstract public function isGranted(IdentityInterface $identity);

    /**
     * @return string
     */
    abstract public function getResourceName();
}
