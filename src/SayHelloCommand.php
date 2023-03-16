<?php

namespace src;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SayHelloCommand extends Command {

     public function configure()
     {
         $this-> setName('sayHelloTo')
             -> setDescription('Offer a greeting to the given person')
             -> addArgument('name', InputArgument::REQUIRED, 'Your name')
             ->addOption('greeting', null, InputOption::VALUE_OPTIONAL, 'Override default greeting', 'Hello');
     }

     public function execute(InputInterface $input, OutputInterface $output)
     {
        $message = sprintf('%s, %s', $input->getOption('greeting'), $input->getArgument('name'));
        $output -> writeln("<info>$message<info>");
        return 0;
     }

}