<?php

namespace App\Controller;

use App\Omdb\OmdbClient;
use App\Repository\InMemoryMovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $movieRepository;

    public function __construct(OmdbClient $omdbClient)
    {
        $this->movieRepository = new InMemoryMovieRepository();
        $this->omdbClient = $omdbClient;
    }

    /**
     * @Route("/", name="home")
     * @Route("/index.html", name="index")
     */
    public function index(): Response
    {
        //$this->container->get(OmdbClient::class);
        $this->omdbClient->requestByTitle('Lord of the rings');
        return $this->render('main/index.html.twig', [
            'movies' => $this->movieRepository->getMovies()
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('main/contact.html.twig', [
        ]);
    }
}
