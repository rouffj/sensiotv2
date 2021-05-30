<?php

namespace App\Command;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieListCommand extends Command
{
    protected static $defaultName = 'movie:list';
    protected static $defaultDescription = 'Add a short description for your command';
    private $entityManager;

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            //->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    public function __construct(EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $movies = $this->entityManager->getRepository(Movie::class)->findAll();


        $rows = [];
        foreach ($movies as $movie) {
            $rows[] = [$movie->getTitle(), $movie->getReleaseDate()->format('Y-m-d'), $movie->getDuration()];
        }

        $io->title('Current movies inside the DB');
        $io->table(['title', 'release date', 'duration'], $rows);

        return Command::SUCCESS;
    }
}
