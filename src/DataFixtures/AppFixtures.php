<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Couleur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        // Liste des choses à ajouter
        $couleurs = array('acajou','arlequin','aubère','belton','sésame','sésame rouge','sésame noir','bicolore','blanc','bleu','blenheim','bigaré','bringé','caille','cannelle','cerf','charbonné','châtain','pluricolore','rouanné','tacheté','tiqueté','zain','chevreuil','chocolat','citron','crème','écaille de tortue','faon','fauve','foie','gris','isabelle','puce','lilas','louvet','marron','merle','moucheté','multicolore','noir','noir et feu','roux','rubis','sable','tigré','alezan','appaloosa','bai','palomino','pie','rouan','souris','blond','papillon','ombré','panaché','pie','particolore','parsemé','pie noir','pie rouge');

        // Admin
        $admin = new User;
        $admin->setEmail('admin@gmail.com');
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setNom($faker->lastName());
        $admin->setPrenom($faker->firstName());
        $admin->setAdresse($faker->streetAddress());
        $admin->setTelephone($faker->phoneNumber());

        $password = $this->hasher->hashPassword($admin, 'admin');
        $admin->setPassword($password);

        $manager->persist($admin);

        // Couleur
        foreach ($couleurs as $couleur) {
            $uneCouleur = new Couleur();
            $uneCouleur->setNom($couleur);

            $manager->persist($uneCouleur);
        }

        $manager->flush();
    }
}
