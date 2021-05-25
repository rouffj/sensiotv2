<?php

namespace App\Controller;

use App\Repository\InMemoryMovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $movieRepository;

    public function __construct()
    {
        $this->movieRepository = new InMemoryMovieRepository();
    }

    /**
     * @Route("/", name="home")
     * @Route("/index.html", name="index")
     */
    public function index(): Response
    {
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
