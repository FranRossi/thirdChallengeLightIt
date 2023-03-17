#! /usr/bin/env php
<?php


use src\ShowCommand;
use Symfony\Component\Console\Application;

require 'vendor/autoload.php';

$app = new Application('Movies App', '1.0');
putenv("API_KEY=d5561d84");

$app->add(new ShowCommand(new GuzzleHttp\Client()));
//add multiple commands.
//example show scarface

$app->run();