<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EventCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('demo:event');
        $this->setDescription('Demo raising console events');
        //true if given, false otherwise
        $this->addOption('raise-exception', 'r', InputOption::VALUE_NONE, 'Raise exception');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('=== Event demo command is running now... ===');

        if ($input->getOption('raise-exception')) {
            throw new \RuntimeException('Raised exception');
        }
    }
}