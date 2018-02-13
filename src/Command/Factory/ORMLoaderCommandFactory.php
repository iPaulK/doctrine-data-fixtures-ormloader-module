<?php
/**
 * @link    https://github.com/iPaulK/doctrine-data-fixtures-ormloader-module.git
 * @license MIT
 */

namespace DoctrineDataFixturesORMLoader\Command\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use DoctrineDataFixturesORMLoader\Command\ORMLoaderCommand;

class ORMLoaderCommandFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $serviceManager = $container->get('ServiceManager');
        
        return new ORMLoaderCommand($entityManager, $serviceManager);
    }
}
