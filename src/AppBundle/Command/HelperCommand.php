<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressHelper;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;


class HelperCommand extends Command
{
    protected function configure()
    {
        $this->setName('demo:helper');
        $this->setDescription('Miscellaneous Helpers demo');
        $this->addArgument('show', InputArgument::REQUIRED, 'Possible values: <comment>formatter, progress, table</comment>');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        switch ($input->getArgument('show')) {
            case 'formatter':
                $this->formatterHelperDemo($output);
                break;
            case 'progress':
                $this->progressHelperDemo($output);
                break;
            case 'table':
                $this->tableHelperDemo($output);
                break;
        }
    }

    private function progressHelperDemo(OutputInterface $output)
    {
        $progress = $this->getHelper('progress');
        $progress->setFormat(ProgressHelper::FORMAT_VERBOSE);
        $progress->setBarCharacter('<info>=</info>');
        $progress->setEmptyBarCharacter(' ');
        $progress->setProgressCharacter('|');
        $progress->setBarWidth(50);
        $progress->start($output, 15);
        $progress->setCurrent(10);

        for ($i = 0; $i < 5; $i++) {
            sleep(1);
            $progress->advance();
        }
        $progress->finish();

        //------------------------------
        $progress->start($output, 5000);

        // update every 100 iterations
        $progress->setRedrawFrequency(100);

        for ($i = 0; $i < 5000; $i++) {
            // do some stuff
            $progress->advance();
        }
        $progress->finish();

    }

    private function formatterHelperDemo(OutputInterface $output)
    {
        $formatter = $this->getHelper('formatter');
        $formattedLine = $formatter->formatSection('Some section', 'Here is a message for the section');
        $output->writeln($formattedLine);

        $messages = ['error', 'Something went wrong', 'This is another line of the message'];
        $formattedBlock = $formatter->formatBlock($messages, 'error', true);
        $output->writeln($formattedBlock);
    }

    private function tableHelperDemo(OutputInterface $output)
    {
        $table = $this->getHelper('table');
        $table
            ->setHeaders(['Hero', 'Organisation'])
            ->setRows([
                ['Wolverine', 'X-men'],
                ['Hulk', 'Avengers'],
                ['Iron man', 'Avengers'],
            ]);
        $table->setLayout(TableHelper::LAYOUT_BORDERLESS);
        $table->render($output);
    }
}