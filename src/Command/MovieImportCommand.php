<?php

namespace App\Command;

use App\Entity\Movie;
use App\Omdb\OmdbClient;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieImportCommand extends Command
{
    protected static $defaultName = 'movie:import';
    protected static $defaultDescription = 'Add a short description for your command';
    private $omdbClient;
    private $entityManager;

    public function __construct(OmdbClient $omdbClient, EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);
        $this->omdbClient = $omdbClient;
        $this->entityManager = $entityManager;
    }


    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('movie_name', InputArgument::OPTIONAL, 'The movie to add into DB')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $movieName = $input->getArgument('movie_name');
        if (!$movieName) {
            $movieName = $io->ask('Which movie do you want to import in the DB?');
        }

        $io->info('We are searching for the movie ' . $movieName);
        $response = $this->omdbClient->requestByTitle($movieName);
        //$this->omdbClient->requestBySearch('Terminator', ['page' => 1]);

        $movie = new Movie();
        $movie
            ->setTitle($response['Title'])
            ->setImage($response['Poster'])
            ->setDirector($response['Director'])
            ->setDuration((int)$response['Runtime'])
        ;

        $moviesFromOmdb = ['...'];
        if (count($moviesFromOmdb) > 10) {
            $answer = $io->ask('Do you want to see the full list of '. count($moviesFromOmdb).' movies', 'yes');

            if ($answer === 'no') {
                return null;
            }
        }

        if ('N/A' !== $response['Released']) {
            $movie->setReleaseDate(new DateTimeImmutable($response['Released']));
        }

        dump($movie);

        //$addToDb = $io->choice('Are you sure to insert into DB the movie ' . $movie->getTitle(), ['yes', 'no']);
        $addToDb = $io->ask('Are you sure to insert into DB the movie ' . $movie->getTitle(), 'yes', function ($answer) {
            if (!in_array($answer, ['yes', 'no'])) {
                throw new \RuntimeException('You should select yes or no');
            }
        });

        if ('yes' === $addToDb) {
            $this->entityManager->persist($movie);
            $this->entityManager->flush();
        }

        $io->success(sprintf('The movie "%s" has been added to the DB', $movie->getTitle()));

        return Command::SUCCESS;
    }
}
