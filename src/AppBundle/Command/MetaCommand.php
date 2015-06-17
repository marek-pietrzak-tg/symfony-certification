<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MetaCommand extends Command
{
    protected function configure()
    {
        $this->setName('demo:meta')
            ->setDescription('Meta command executing greet one')
            ->addArgument('name', InputArgument::OPTIONAL, 'Who do you want to greet?', 'world');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $greetCommand = $this->getApplication()->find('demo:greet');
        $parameters = [
            'name' => $input->getArgument('name'),
            '--yell' => true
        ];

        $inputArray = new ArrayInput($parameters);

        $returnCode = $greetCommand->run($inputArray, $output);
        $output->writeln(sprintf('<info>Greet command finished with code %d</info>', $returnCode));
    }
}