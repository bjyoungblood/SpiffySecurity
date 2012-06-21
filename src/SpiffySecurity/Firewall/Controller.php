<?php

namespace SpiffySecurity\Firewall;

use SpiffySecurity\Identity\IdentityInterface;

class Controller extends AbstractFirewall
{
    protected $rules = array();
    protected $resourceName;

    public function __construct(array $rules, $security)
    {
        $this->securityService = $security;

        foreach($rules as $rule) {
            if (!is_array($rule['roles'])) {
                $rule['roles'] = array($rule['roles']);
            }
            if (isset($rule['action'])) {
                $this->rules[$rule['controller']][$rule['action']] = $rule['roles'];
                $this->resourceName = sprintf('controller/%s:%s', $rule['controller'], $rule['action']);
            } else {
                $this->rules[$rule['controller']] = $rule['roles'];
                $this->resourceName = sprintf('controller/%s', $rule['controller']);
            }
        }
    }

    /**
     * Checks if access is granted to resource for the role.
     *
     * @param \SpiffySecurity\Identity\IdentityInterface $identity
     * @param string $resource
     * @return bool
     */
    public function isGranted(IdentityInterface $identity)
    {
        if ($this->securityService->getAcl()->hasResource($this->getResourceName())) {
            return $this->securityService->isGranted($identity, $this->getResourceName());
        }

        // TODO maybe add the ability to deny by default
        return true;
    }

    /**
     * Get the firewall name.
     *
     * @return string
     */
    public function getName()
    {
        return 'controller';
    }
 
    public function getResourceName()
    {
        return $this->resourceName;
    }
}
