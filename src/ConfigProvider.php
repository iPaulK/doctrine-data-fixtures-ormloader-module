<?php
/**
 * @link    https://github.com/iPaulK/doctrine-data-fixtures-ormloader-module.git
 * @license MIT
 */

namespace DoctrineDataFixturesORMLoader;

class ConfigProvider
{
    /**
     * Retrieve configuration for zend-mail package.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    /**
     * Retrieve dependency settings for zend-mail package.
     *
     * @return array
     */
    public function getDependencyConfig()
    {
        return [
            'factories' => [
                Command\ORMLoaderCommand::class => Command\Factory\ORMLoaderCommandFactory::class,
            ],
        ];
    }
}
