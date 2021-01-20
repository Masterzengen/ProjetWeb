<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UberverooController extends AbstractController
{
    /**
     * @Route("/", name="uberveroo")
     */
    public function index(): Response
    {
        return $this->render('uberveroo/test.html.twig', [
            
        ]);
    }
}
