<?php

namespace SpiffySecurity\Service;

use Zend\Stdlib\Options;

class SecurityOptions extends Options
{
    /**
     * The default role that is used if no role is found from the
     * role provider.
     *
     * @var string
     */
    protected $anonymousRole = 'anonymous';

    /**
     * Flag: enable or disable the routing firewall.
     *
     * @var bool
     */
    protected $firewallRoute = false;

    /**
     * Flag: enable or disable the controller firewall.
     *
     * @var bool
     */
    protected $firewallController = true;

    /**
     * Set the view template to use on a 403 error.
     *
     * @var string
     */
    protected $template = 'error/403';

    /**
     * Set the identity provider to use. The identity provider must be retrievable from the
     * service locator and must implement \SpiffySecurity\Identity\IdentityInterface.
     *
     * @var string
     */
    protected $identityProvider =  'my_identity_provider';

    /**
     * Array of firewall rules.
     *
     * @var array
     */
    protected $firewalls = array();

    /**
     * Array of role providers.
     *
     * @var array
     */
    protected $roleProviders = array();

    public function setFirewallController($firewallController)
    {
        $this->firewallController = $firewallController;
        return $this;
    }

    public function getFirewallController()
    {
        return $this->firewallController;
    }

    public function setFirewallRoute($firewallRoute)
    {
        $this->firewallRoute = $firewallRoute;
        return $this;
    }

    public function getFirewallRoute()
    {
        return $this->firewallRoute;
    }

    public function setFirewalls($firewalls)
    {
        $this->firewalls = $firewalls;
        return $this;
    }

    public function getFirewalls()
    {
        return $this->firewalls;
    }

    public function setIdentityProvider($identityProvider)
    {
        $this->identityProvider = $identityProvider;
        return $this;
    }

    public function getIdentityProvider()
    {
        return $this->identityProvider;
    }

    public function setRoleProviders($providers)
    {
        $this->roleProviders = $providers;
        return $this;
    }

    public function getRoleProviders()
    {
        return $this->roleProviders;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setAnonymousRole($anonymousRole)
    {
        $this->anonymousRole = $anonymousRole;
        return $this;
    }

    public function getAnonymousRole()
    {
        return $this->anonymousRole;
    }
}
