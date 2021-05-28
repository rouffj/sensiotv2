<?php

namespace App\Controller;

use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\Movie;
use App\Entity\User;
use App\Entity\Review;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/register.html", name="register")
     */
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //$form = $this->createForm('App\Form\RegisterType');
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $encodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);

            $entityManager->persist($user);
            $entityManager->flush();
            dump($user);
        }

        return $this->render('user/register.html.twig', [
            'register_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login.html", name="login")
     */
    //public function login(): Response
    //{
    //    return $this->render('user/login.html.twig', [
    //    ]);
    //}

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
    public function profile(EntityManagerInterface $entityManager): Response
    {
        /*
        $movie = new Movie();
        $movie
            ->setTitle('Movie title')
            ->setReleaseDate(new \DateTime())
            ->setDirector('Director name')
            ->setDuration(103)
            ->setImage('/assets/images/movie-image-samples/memento.jpeg')
        ;

        $user = new User();
        $user
            ->setEmail('test@test.fr')
            ->setFirstName('Joseph')
            ->setLastName('ROUFF')
            ->setPassword('!test')
        ;

        $entityManager->persist($movie);
        $entityManager->persist($user);
        */

        $movieWithIdOne = $entityManager->find(Movie::class, 1);
        $userWithIdTwo = $entityManager->find(User::class, 2);
        //$user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'test@test.fr'])

        $review = new Review();
        $review
            ->setMovie($movieWithIdOne)
            ->setUser($userWithIdTwo)
            ->setBody('This is my comment about the movie 1')
        ;

        $entityManager->persist($review);
        $entityManager->flush();

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

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}
