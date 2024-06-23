<?php

use Warkrai\ToDoItem\CommandProcessor;
use Warkrai\ToDoItem\Container;

require_once __DIR__ . '/vendor/autoload.php';

$container = Container::getInstance();
/** @var CommandProcessor $commandProcessor */
$commandProcessor = $container->get(CommandProcessor::class);

$commandProcessor->run();
