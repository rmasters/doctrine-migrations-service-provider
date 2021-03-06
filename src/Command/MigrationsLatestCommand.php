<?php

namespace Rossible\Provider\DoctrineMigrationsProvider\Command;

use Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationsLatestCommand extends LatestCommand
{
    use DoctrineCommandTrait;

    protected function configure()
    {
        parent::configure();

        $this->setName('doctrine:migrations:configure')
            ->addOption('em', null, InputOption::VALUE_OPTIONAL, 'The entity manager to use for this command.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Pimple\Container $container */
        $container = $this->getHelper('pimple')->getContainer();

        $this->setApplicationEntityManager($container, $this->getApplication(), $input->getOption('em'));

        $configuration = $this->getMigrationConfiguration($input, $output);
        $this->configureMigrations($container, $configuration);

        parent::execute($input, $output);
    }
}