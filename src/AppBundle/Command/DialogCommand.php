<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class DialogCommand extends Command
{
    protected function configure()
    {
        $this->setName('demo:dialog');
        $this->setDescription('Dialog Helper demo');
        $this->addOption('none', 'g', InputOption::VALUE_NONE);
        $this->addOption('optional', 'o', InputOption::VALUE_OPTIONAL);
        $this->addOption('required', 'r', InputOption::VALUE_REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialogHelper = new DialogHelper();

        if (!$this->askConfirmation($output, $dialogHelper)){
            return;
        }

        $this->ask($output, $dialogHelper);
        $this->askHidden($output, $dialogHelper);
        $this->askAndValidate($output, $dialogHelper);
    }

    private function askConfirmation(OutputInterface $output, DialogHelper $dialogHelper)
    {
        // will keep asking for confirmation unless ['y','n',<enter>, <space>] pressed
        if (!$dialogHelper->askConfirmation($output, 'Continue? ')) {
            $output->writeln('Leaving...');
            return;
        }

        $output->writeln('OK, so let\'s continue');
        return true;
    }

    private function ask(OutputInterface $output, DialogHelper $dialogHelper)
    {
        $frameworks = ['Symfony', 'Zend Framework', 'Phalcon'];
        $usersChoice = $dialogHelper->ask($output, 'What is your favourite framework? ', 'Symfony', $frameworks);
        $output->writeln(sprintf("Your favourite framework is: <comment>%s</comment>", $usersChoice));
    }

    private function askHidden(OutputInterface $output, DialogHelper $dialogHelper)
    {
        $secret = $dialogHelper->askHiddenResponse($output, 'What is your secret? ', false);
        $output->writeln(sprintf("Your secret is: <comment>%s</comment>", $secret));
    }

    private function askAndValidate(OutputInterface $output, DialogHelper $dialogHelper)
    {
        // if dialog helper doesn't have formatter helper in a helper set, we fatal error is thrown
        $helperSet = new HelperSet([new FormatterHelper()]);
        $dialogHelper->setHelperSet($helperSet);

        $usersChoice = $dialogHelper->askAndValidate(
            $output,
            'What is your favourite framework? ',
            function($answer){
                if ('Laravel' === $answer) {
                    throw new \RuntimeException('Are you kidding me?');
                }
                return $answer;
            },
            false
        );
        $output->writeln(sprintf("Your favourite framework is: <comment>%s</comment>", $usersChoice));
    }
}