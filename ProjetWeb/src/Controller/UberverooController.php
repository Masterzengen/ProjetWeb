<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Restaurant;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class UberverooController extends AbstractController
{
    /**
     * @Route("/", name="uberveroo")
     */
    public function index(): Response
    {
        return $this->render('uberveroo/index.html.twig', [
            
        ]);
    }
    /**
    * @Route("/restaurants", name="restaurants")
    */

    public function restaurantsListe(){
        $repo = $this->getDoctrine()->getRepository(Restaurant::class);
        $resto = $repo->findAll();
        return $this->render('uberveroo/restaurant.html.twig',[
            'restaurants' => $resto
        ]);
    }


    /**
     * @Route ("/restaurant/{id}", name="restoShow")
     */

    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Restaurant::class);
        $resto = $repo->find($id);
        return $this->render('uberveroo/show.html.twig', [
            'resto' => $resto
        ]);
    }

     /**
     * @Route ("/restaurant/commander/{id}", name="commander")
     */

     public function commander($id){
        $repo = $this->getDoctrine()->getRepository(Restaurant::class);
        $resto = $repo->find($id);
        return $this->render('uberveroo/commander.html.twig', [
            'resto' => $resto
        ]);
     }


}
