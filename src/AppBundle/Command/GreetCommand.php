<?php

namespace AppBundle\Command;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputOption;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use \Symfony\Component\Console\Formatter\OutputFormatterStyle;

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

        /*---------------------- tags ----------------------------*/
        $output->writeln('<info>Green text</info>');
        $output->writeln('<comment>Yellow text</comment>');
        $output->writeln('<question>Black text on cyan background</question>');
        $output->writeln('<error>White text on red background</error>');

        /*---------------------- custom styles ----------------------------*/
        // available colours: black, red, green, yellow, blue, magenta, cyan and white.
        // available options: bold, underscore, blink, reverse and conceal.
        $style = new OutputFormatterStyle('red', 'yellow', ['bold']);
        $output->getFormatter()->setStyle('fire', $style);
        $output->writeln('<fire>This text is on fire</fire>');

        $style->setOption('reverse');
        $output->writeln('<fire>Style now reversed</fire>');

        $greenStyle = new OutputFormatterStyle('green', 'white', ['bold', 'underscore']);
        $output->writeln($greenStyle->apply('this is a different way of applying style to the text'));

        /*---------------------- custom style in tag ----------------------------*/
        $output->writeln('<fg=magenta;bg=green;options=bold>Custom style in tag</fg=magenta;bg=green;options=bold>');

        /*---------------------- verbosity ----------------------------*/
        if (OutputInterface::VERBOSITY_NORMAL < $output->getVerbosity()) {
            $output->writeln("This text is visible only when verbosity level is higher than normal");
        } else {
            $output->writeln('To see hidden text use -v option');
        }
    }
}