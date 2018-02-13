<?php
/**
 * @link    https://github.com/iPaulK/doctrine-data-fixtures-ormloader-module.git
 * @license MIT
 */

namespace DoctrineDataFixturesORMLoader;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use DoctrineDataFixturesORMLoader\Command\ORMLoaderCommand;

/**
 * Base module for Doctrine Data Fixtures ORMLoader.
 */
class Module implements InitProviderInterface, ConfigProviderInterface
{
    /**
     * Initialize workflow
     *
     * @param  ModuleManagerInterface $manager
     */
    public function init(ModuleManagerInterface $manager)
    {
        $events = $manager->getEventManager()->getSharedManager();

        // Attach to helper set event and load the entity manager helper.
        $events->attach('doctrine', 'loadCli.post', function (EventInterface $e) {
            /* @var $cli \Symfony\Component\Console\Application */
            $cli = $e->getTarget();

            /* @var $sm ServiceLocatorInterface */
            $sm = $e->getParam('ServiceManager');

            $сommand = $sm->get(ORMLoaderCommand::class);

            $cli->add($сommand);
        });
    }

    /**
     * Retrieve doctrine-data-fixtures-ormloader-module package configuration for zend-mvc context.
     *
     * @return array
     */
    public function getConfig()
    {
        $provider = new ConfigProvider();
        return [
            'service_manager' => $provider->getDependencyConfig(),
        ];
    }
}
