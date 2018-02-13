<?php
/**
 * @link    https://github.com/iPaulK/doctrine-data-fixtures-ormloader-module.git
 * @license MIT
 */

namespace DoctrineDataFixturesORMLoader\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManager;

class ORMLoaderCommand extends Command
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    public function __construct(EntityManager $entityManager, ServiceManager $serviceManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->serviceManager = $serviceManager;
    }

    /**
     * Configures the current command.
     */
    public function configure()
    {
        parent::configure();

        $this->setName('orm:data-fixtures:load')
            ->setDescription('Data Fixtures ORMLoder')
            ->addOption('purge-mode-delete', 'delete', InputOption::VALUE_NONE)
            ->addOption('purge-mode-truncate', 'truncate', InputOption::VALUE_NONE);
        
        $this->setHelp(<<<EOT
The <info>%command.name%</info> command loading of data fixtures for the Doctrine ORM from a directories
EOT
        );
    }

    /**
     * Executes the current command.
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $loader = new Loader();
        foreach ($this->getDirectories() as $key => $value) {
            $loader->loadFromDirectory($value);
        }

        $purger = new ORMPurger();
        if ($input->getOption('purge-with-truncate')) {
            $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        }

        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures(), $input->getOption('purge-mode-delete'));
    }

    /**
     * Get directories from configuration
     *
     * @return array
     */
    private function getDirectories()
    {
        return $this->serviceManager->get('config')['doctrine']['fixture'] ?? [];
    }
}
