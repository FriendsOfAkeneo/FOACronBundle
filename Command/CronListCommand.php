<?php

namespace FOA\CronBundle\Command;

use Pim\Bundle\TextmasterBundle\Project\ProjectInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Textmaster\Exception\ErrorException;
use Textmaster\Model\ProjectInterface as ApiProjectInterface;

/**
 * @author    Jean-Marie Leroux <jean-marie.leroux@akeneo.com>
 */
class CronListCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('foa:cron:list')
            ->setDescription('Display crontab');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cronManager = $this->getContainer()->get('foa.cron_bundle.cron_manager');
        $crons = $cronManager->getCrons();

        dump($crons);
    }
}
