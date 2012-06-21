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
    public function isGranted(IdentityInterface $identity, $resource)
    {
        $resource   = explode(':', $resource);
        $controller = $resource[0];
        $action     = isset($resource[1]) ? $resource[1] : null;

        // Check action first
        if (isset($this->rules[$controller][$action])) {
            $roles = $this->rules[$controller][$action];
        } else if (isset($this->rules[$controller])) {
            $roles = $this->rules[$controller];
        } else {
            return true;
        }

        return $this->securityService->isGranted($roles);
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
