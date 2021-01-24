<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Plats;
use App\Entity\Restaurant;
use App\Entity\Type;
use Faker\Factory;
use Faker;

class RestaurantFixtures extends Fixture 
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $typeNormal = new Type();
        $typeNormal->setRegime("Normal");

        $typeVege = new Type();
        $typeVege->setRegime("Végétarien");

        $typeVegan = new Type();
        $typeVegan->setRegime("Vegan");

        $manager->persist($typeNormal);
        $manager->persist($typeVege);
        $manager->persist($typeVegan);
        // $product = new Product();
        // $manager->persist($product);
       
            

        

        
        for($i=1; $i<=15; $i++){
            $resto = new Restaurant();
            $resto->setNom("Resto incroyable n°$i")
                ->setAdresse($faker->streetAddress)
                ->setEmail($faker->email)
              
                ->addType($faker->randomElement($array = array ($typeNormal,$typeVege,$typeVegan)))
                ->setLogo("http://placehold.it/150x150");

            for($j=1; $j<=10; $j++){
                    $plat = new Plats();
                    $plat->setNom("Plat excellent n°$j")
                         ->setDescription("Description incroyable de ce plat merveilleux n°$j")
                         ->setPrix($faker->numberBetween($min = 8, $max = 60))
                         ->setPhoto("http://placehold.it/100x100")
                         ->setRestaurant($resto);
                    $manager->persist($plat);
                    $resto->addPlat($plat);
                   
             }
             $manager->persist($resto);
            
            
        }
        

        $manager->flush();
        }
}
