<?php

// use Symfony\Component\HttpClient\HttpClient;
require 'vendor/autoload.php';

$console = new \Symfony\Component\Console\Application();
$console->add(new \App\GreetCommand());
$console->add(new \App\SearchCommand());
$console->run();

// composer dumpautoload