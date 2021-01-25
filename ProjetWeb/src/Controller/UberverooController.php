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
use App\Entity\Plats;
use App\Form\PlatsType;
use App\Form\RestaurantType;
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

         /**
     * @Route ("/ajouter", name="ajouter")
     * @Route ("/editer/{id}", name ="edit")
     */

    public function ajouter(Restaurant $resto = null, Request $request, EntityManagerInterface $em){
       
         if(!$resto){
            $resto = new Restaurant(); 
         }

         

         $form = $this->createForm(RestaurantType::class, $resto);
    

         $form->handleRequest($request);

         


        if($form->isSubmitted() ){
            $plats = new Plats();
            $plats->setNom("Template temporaire")
                ->setDescription("Description temporaire")
                ->setPrix("0")
                ->setPhoto("http://placehold.it/100x100")
                ->setRestaurant($resto);
            $em->persist($plats);
            $resto->addPlat($plats);
            $em->persist($resto);
            $em->flush();
            return $this->redirectToRoute('ajouterplat',['id'=>$resto->getId()]);
        }


         return $this->render('uberveroo/ajouter.html.twig',[
             "form" => $form->createView()
         ]);



     }


           /**
     * @Route ("/ajouter/plat/{id}", name="ajouterplat")
     * @Route ("/editer/plat/{id}", name ="editplat")
     */

    public function ajouterPlat(Plats $plat = null, Request $request, EntityManagerInterface $em, $id){
       
        if(!$plat){
           $plat = new Plats(); 
        }

        $form = $this->createForm(PlatsType::class, $plat);

        

       
   

        $form->handleRequest($request);
       
        $repo = $this->getDoctrine()->getRepository(Restaurant::class);
        $resto = $repo->find($id);


       if($form->isSubmitted() ){
            $plat->setRestaurant($resto);
           $em->persist($plat);
           $resto->addPlat($plat);
           $em->persist($resto);
           $em->flush();
           return $this->redirectToRoute('restoShow',['id'=>$resto->getId()]);
       }


        return $this->render('uberveroo/ajouterPlats.html.twig',[
            "form" => $form->createView()
        ]);



    }

    /**
     * @Route ("/Restaurant/supprimer/{id}", name="supprimer")
     */

    public function supprimer($id, EntityManagerInterface $em){
        $repo = $this->getDoctrine()->getRepository(Restaurant::class)->find($id);
        



        $em->remove($repo);
        $em->flush();
        return $this->redirectToRoute('restaurants');

     }



}
