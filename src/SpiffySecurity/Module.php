<?php

namespace SpiffySecurity;

class Module
{
    public function onBootstrap($e)
    {
        $app      = $e->getTarget();
        $sm       = $app->getServiceManager();
        $security = $sm->get('SpiffySecurity\Service\Security');
        $strategy = $sm->get('SpiffySecurity\View\UnauthorizedStrategy');

        if ($security->options()->getFirewallRoute()) {
            $app->events()->attach('route', array('SpiffySecurity\Firewall\Listener\Route', 'onRoute'), -1000);
        }

        if ($security->options()->getFirewallController()) {
            $app->events()->attach('route', array('SpiffySecurity\Firewall\Listener\Controller', 'onRoute'), -1000);
        }

        $app->events()->attach($strategy);
    }

    public function getServiceConfiguration()
    {
        return array(
            'aliases' => array(
                'service.security' => 'SpiffySecurity\Service\Security',
            ),
            'invokables' => array(
                'isGranted' => 'SpiffySecurity\Controller\Plugin\IsGranted',
            ),
            'factories' => array(
                'SpiffySecurity\Controller\Plugin\IsGranted' => function($sm) {
                    return new \SpiffySecurity\Controller\Plugin\IsGranted(
                        $sm->get('SpiffySecurity\Service\Security')
                    );
                },
                'SpiffySecurity\View\Helper\IsGranted' => function($sm) {
                    return new \SpiffySecurity\View\Helper\IsGranted(
                        $sm->get('SpiffySecurity\Service\Security')
                    );
                },
                'SpiffySecurity\Provider\Resource\Firewall' => function($sm) {
                    return new \SpiffySecurity\Provider\Resource\Firewall($sm->get('SpiffySecurity\Service\Security'));
                },
                'SpiffySecurity\View\UnauthorizedStrategy' => 'SpiffySecurity\Service\UnauthorizedStrategyFactory',
                'SpiffySecurity\Service\Security'          => 'SpiffySecurity\Service\SecurityFactory'
            )
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
}
