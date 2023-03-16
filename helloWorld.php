#! /usr/bin/env php
<?php

use src\SayHelloCommand;
use Symfony\Component\Console\Application;

require 'vendor/autoload.php';

$app = new Application('Hello World Demo', '1.0');


$app->add(new SayHelloCommand);
//add multiple commands.
//example show scarface

$app->run();