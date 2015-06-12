<?php

use AppBundle\Command\EventCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

require __DIR__ . '/../vendor/autoload.php';

// --- register listeners
$eventDispatcher = new EventDispatcher();
$eventDispatcher->addListener(ConsoleEvents::COMMAND, 'beforeListener');
$eventDispatcher->addListener(ConsoleEvents::TERMINATE, 'terminateListener');
$eventDispatcher->addListener(ConsoleEvents::EXCEPTION, 'exceptionListener');

// --- application
$application = new Application();
$application->setDispatcher($eventDispatcher);
$application->add(new EventCommand());
$application->run();

// --- listeners
function beforeListener(ConsoleCommandEvent $event)
{
    $output = $event->getOutput();
    $command = $event->getCommand();

    $output->writeln(sprintf("<info>Before running command: %s</info>", $command->getName()));
}

function terminateListener(ConsoleTerminateEvent $event)
{
    $output = $event->getOutput();
    $command = $event->getCommand();

    // change exit code
    $event->setExitCode(888);

    $output->writeln(sprintf("<comment>After running command: %s</comment>", $command->getName()));
}

function exceptionListener(ConsoleExceptionEvent $event)
{
    $output = $event->getOutput();
    $command = $event->getCommand();

    $output->writeln(sprintf('<error>Oops, exception thrown while running command "%s"</error>', $command->getName()));

    // get current exit code (the exception code or changed by ConsoleEvents::TERMINATE)
    $exitCode = $event->getExitCode();

    // change the exception to another one
    $event->setException(new \LogicException('Exception raised in listener', $exitCode, $event->getException()));
}