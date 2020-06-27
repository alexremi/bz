<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class GuestController extends AbstractController
{
    /**
     * @Route("/guest", name="guest1")
     */
    public function index()
    {
        return $this->render('guest/classifier.html.twig');
    }

    /**
     * @Route("/guestfarfor", name="guest_farfor")
     */
    public function indexfarfor()
    {
        return $this->render('guest/guestfarfor.html.twig', [
            'controller_name' => 'GuestController',
        ]);
    }

    /**
     * @Route("/guestceramic", name="guest_ceramic")
     */
    public function indexceramic()
    {
        return $this->render('guest/guestceramic.html.twig', [
            'controller_name' => 'GuestController',
        ]);
    }
}
