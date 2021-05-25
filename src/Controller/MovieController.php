<?php

namespace App\Controller;

use App\Repository\InMemoryMovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movie", name="movie_")
 */
class MovieController extends AbstractController
{
    private $movieRepository;

    public function __construct()
    {
        $this->movieRepository = new InMemoryMovieRepository();
    }

    /**
     * @Route("/{id}", name="detail", requirements={"id": "\d+"})
     */
    public function movieDetail($id): Response
    {
        return $this->render('movie/movie-details.html.twig', [
            'movie' => $this->movieRepository->getMovieById($id)
        ]);
    }

    /**
     * @Route("/top-rated", name="top_rated")
     */
    public function topRated(): Response
    {
        return $this->render('movie/movie-top-rated.html.twig', [
        ]);
    }

    /**
     * @Route("/movie/my-{id}", name="show_movie", methods={"GET"})
     */
    public function showMovie($id): Response
    {
        return new Response('The movie id is ' . $id);
    }

    /**
     * @Route("/movie/my-{id}", name="show_movie_post", methods={"POST"})
     */
    public function showMovieWithPost($id): Response
    {
        return new Response('The movie id is ' . $id);
    }
}