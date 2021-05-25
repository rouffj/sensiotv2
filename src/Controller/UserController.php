<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/register.html", name="register")
     */
    public function register(): Response
    {
        return $this->render('user/register.html.twig', [
        ]);
    }

    /**
     * @Route("/login.html", name="login")
     */
    public function login(): Response
    {
        return $this->render('user/login.html.twig', [
        ]);
    }

    /**
     * @Route("/user-cart.html", name="cart")
     */
    public function cart(): Response
    {
        return $this->render('user/user-cart.html.twig', [
        ]);
    }

    /**
     * @Route("/user-profile.html", name="profile")
     */
    public function profile(): Response
    {
        return $this->render('user/user-profile.html.twig', [
        ]);
    }

    /**
     * @Route("/user-watchlist.html", name="watchlist")
     */
    public function watchlist(): Response
    {
        return $this->render('user/user-watchlist.html.twig', [
        ]);
    }

}
