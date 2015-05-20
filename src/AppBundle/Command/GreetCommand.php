<?php

namespace AppBundle\Command;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputOption;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;

class GreetCommand extends Command
{
    protected function configure()
    {
        $this->setName('demo:greet')
            ->setDescription('Greet someone')
            ->addArgument('name', InputArgument::OPTIONAL, 'Who do you want to greet?', 'world')
            ->addOption('yell', 'y', InputOption::VALUE_NONE, 'If set then greeting will be uppercase');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $message = sprintf("Hello %s", $input->getArgument('name'));

        if ($input->getOption('yell')) {
            $message = strtoupper($message);
        }

        $output->writeln($message);
        $output->writeln('<info>Green text</info>');
        $output->writeln('<comment>Yellow text</comment>');
        $output->writeln('<question>Black text on cyan background</question>');
        $output->writeln('<error>White text on red background</error>');
    }
}