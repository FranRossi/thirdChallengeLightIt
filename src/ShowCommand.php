<?php

namespace src;

use GuzzleHttp\ClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShowCommand extends Command
{
    private $client;
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        parent::__construct();
    }

    public function configure()
    {
        $this->setName('show')
            ->setDescription('Show a movie info')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the movie')
            ->addOption('fullPlot', 'f', InputOption::VALUE_NONE, 'Show full plot');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $movieName = $input->getArgument('name');
        $fullPlot = $input->getOption('fullPlot');

        $this->showMovie($movieName,$fullPlot , $output);
        return 0;
    }

    private function showMovie($movieName,$optionFullPlot, OutputInterface $output)
    {
        $movie = $this->getMovie($movieName, $optionFullPlot);
        $table = new Table($output);
        //Make an output an info message with the title and year of the movie
        $output->writeln('<info>' . $movie['Title'] . ' - ' . $movie['Year'] . '</info>');

        $table->setHeaders($this->setMovieHeaders())
            ->setRows($this->setMovieRows($movie))
            ->setVertical()
            ->render();
        
    }

    private function getMovie($movieName, $optionFullPlot)
    {
        $apiKey = getenv('API_KEY');

        $url = 'http://www.omdbapi.com/?apikey=' . $apiKey . '&t=' . $movieName ;
        if ($optionFullPlot) {
            $url .= '&plot=full';
        }

        $response = $this->client->get($url);

        return json_decode($response->getBody(), true);
    }

    private function setMovieHeaders()
    {
        return ['Title', 'Year', 'Rated', 'Released', 'Runtime', 'Genre', 'Director', 'Writer', 'Actors', 'Plot', 'Language', 'Country', 'Awards', 'Poster', 'Metascore', 'imdbRating', 'imdbVotes', 'imdbID', 'Type', 'Response'];
    }

    private function setMovieRows($movie)
    {
        //Adds rows to the table of type TableSeparator|array
        return [
            [$movie['Title'], $movie['Year'], $movie['Rated'], $movie['Released'], $movie['Runtime'], $movie['Genre'], $movie['Director'], $movie['Writer'], $movie['Actors'], $movie['Plot'], $movie['Language'], $movie['Country'], $movie['Awards'], $movie['Poster'], $movie['Metascore'], $movie['imdbRating'], $movie['imdbVotes'], $movie['imdbID'], $movie['Type'], $movie['Response']]
        ];
    }
}