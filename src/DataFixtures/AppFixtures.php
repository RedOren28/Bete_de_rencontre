<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Poil;
use App\Entity\Race;
use App\Entity\User;
use App\Entity\Espece;
use App\Entity\Regime;
use App\Entity\Couleur;
use App\Entity\Alimentation;
use App\Entity\Annonce;
use App\Entity\Animal;
use App\Entity\Image;
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
        $faker = Factory::create('fr_FR');

        // Liste des choses à ajouter
        $couleurs = array('-Autre-','acajou','alezan','appaloosa','arlequin','aubère','bai','belton','bicolore','bigaré','blanc','blenheim','bleu','blond','bringé','caille','cannelle','cerf','charbonné','chevreuil','chocolat','châtain','citron','crème','écaille de tortue','faon','fauve','foie','gris','isabelle','lilas','louvet','marron','merle','moucheté','multicolore','noir','noir et feu','ombré','palomino','panaché','papillon','parsemé','particolore','pie','pie','pie noir','pie rouge','pluricolore','puce','rouan','rouanné','roux','rubis','sable','souris','sésame','sésame noir','sésame rouge','tacheté','tigré','tiqueté','zain');
        $poils = array('nu','ras','court','mi-long','long');
        $carnivore = array('insectes','poissons','agneau','boeuf','dinde','porc','poulet');
        $omnivore = array('céréales','fruits','herbe','légumes','insectes','poissons','agneau','boeuf','dinde','porc','poulet');
        $vegetarien = array('céréales','fruits','herbe','légumes');
        $chats = array('-Autre-','Abyssin','American Bobtail','American Curl','American Shorthair','American Wirehair','Angora Turc','Balinais','Bengal','Birman','Bleu Russe','Bobtail Japonais','Bombay','British Longhair','British Shorthair','Ceylan','Chartreux','Cornish Rex','Devon Rex','Européen','Exotic Shorthair','German Rex','Havana Brown','Highland Fold','Javanais','Lynx Domestique','Maine Coon','Mandarin','Manx','Mau Egyptien','Norvégien','Ocicat','Oriental Shorthair','Persan','Ragdoll','Savannah','Scottish Fold','Siamois','Sibérien','Somali','Sphynx','Thaï','Tonkinois','York Chocolat');
        $chevaux = array('-Autre-','Andalou','Anglo arabe','Appaloosa','Arabe','Barbe','Boulonnais','Breton camarguais','Cheval de Sang Belge','Cheval de Selle Français','Cheval miniature','Cob normand','Comtois','Connemara','Dartmoor','Falabella','Fjord','Frison','Haflinger','Henson','Highland','Lipizzan','Lusitanien','Merens','Mustang','New forest','Palomino','Percheron','Pinto','Poitevin','Poney Français de selle','Pottok','Pur sang anglais','Pur sang arabe','Quarter Horse','Shetland','Shire','Trait breton','Trait du Nord','Trait mulassier poitevin','Trotteur','Welsh cob');
        $chiens = array('-Autre-','Akita Inu','American hairless Terrier','American staffordshire terrier','Barzoï','Basset','Beagle','Beauceron','Bedlington Terrier','Berger Allemand','Berger Australien','Berger blanc','Berger de Groenendael','Berger de Tervueren','Berger Malinois','Bichon','Bobtail','Border Collie','Boston Terrier','Bouledogue','Bouledogue Américain','Bouledogue Anglais','Bouledogue Français','Bouvier Bernois','Bouvier des Flandres','Boxer','Brabançon','Braque','Briard','Bull Terrier','Bullmastiff','Cairn Terrier','Cane Corso','Caniche','Carlin','Cavalier King Charles','Chien Chinois à Crête','Chien nu du Pérou','Chihuahua','Chow Chow','Cocker','Colley','Coton de Tulear','Dalmatien','Dobermann','Dogue Allemand','Dogue Argentin','Dogue de Bordeaux','Drathaar','Epagneul','Epagneul nain continental','Fox Terrier','Golden Retriever','Grand Bleu de Gascogne','Griffon','Husky','Jack Russell','Labrador','Labrit','Leonberg','Lhassa Apso','Lion d\'Occitanie','Lévrier','Malamute','Mastiff','Montagne des Pyrénées','Mâtin de Naples','Mâtin des Pyrénées','Nizinny','Pinscher','Pointer','Pékinois','Retriever','Rottweiler','Saint Bernard','Saint Hubert','Schnauzer','Setter','Shar Peï','Shetland','Shiba Inu','Shih Tzu','Spitz','Springer Spaniel','Staffordshire Bull Terrier','Teckel','Terre Neuve','West Highland White Terrier','Whippet','Yorkshire');
        $oiseaux = array('-Autre-','Perroquet');
        $reptiles = array('-Autre-','Anaconda','Boa','Couleuvre','Elaphe','Iguane','Lampropeltis','Python');
        $rongeurs = array('-Autre-','Chien de prairie','Cochon d\'Inde','Gerbille','Hamster','Lapin','Rat','Souris');

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

        // Poil
        foreach ($poils as $poil) {
            $unpoil = new Poil();
            $unpoil->setType($poil);

            $manager->persist($unpoil);
        }

        // Regime Carnivore
        $Carnivore= new Regime();
        $Carnivore->setNom('Carnivore');

        //Alimentation Carnivore
        foreach ($carnivore as $carni) {
            $unCarni = new Alimentation();
            $unCarni->setNom($carni);
            $unCarni->addRegime($Carnivore);

            $manager->persist($unCarni);
        }

        // Regime Omnivore
        $Omnivore= new Regime();
        $Omnivore->setNom('Omnivore');

        //Alimentation Omnivore
        foreach ($omnivore as $omni) {
            $unOmni = new Alimentation();
            $unOmni->setNom($omni);
            $unOmni->addRegime($Omnivore);

            $manager->persist($unOmni);
        }
         
        // Regime Végétarien
        $Vegetarien= new Regime();
        $Vegetarien->setNom('Vegetarien');

        //Alimentation Végétarien
        foreach ($vegetarien as $vege) {
            $unVege = new Alimentation();
            $unVege->setNom($vege);
            $unVege->addRegime($Vegetarien);

            $manager->persist($unVege);
        }

        // Espèce Chat
        $Chat= new Espece();
        $Chat->setNom('Chat');

        // Race Chat
        foreach ($chats as $chat) {
            $unChat = new Race();
            $unChat->setNom($chat);
            $unChat->setEspece($Chat);

            $manager->persist($unChat);
        }

        // Espèce Cheval
        $Cheval= new Espece();
        $Cheval->setNom('Cheval');

        // Race Cheval
        foreach ($chevaux as $cheval) {
            $unCheval = new Race();
            $unCheval->setNom($cheval);
            $unCheval->setEspece($Cheval);

            $manager->persist($unCheval);
        }

        // Espèce Chien
        $Chien= new Espece();
        $Chien->setNom('Chien');

        // Race Chien
        foreach ($chiens as $chien) {
            $unChien = new Race();
            $unChien->setNom($chien);
            $unChien->setEspece($Chien);

            $manager->persist($unChien);
        }

        // Espèce Oiseau
        $Oiseau= new Espece();
        $Oiseau->setNom('Oiseau');

        // Race Oiseau
        foreach ($oiseaux as $oiseau) {
            $unOiseau = new Race();
            $unOiseau->setNom($oiseau);
            $unOiseau->setEspece($Oiseau);

            $manager->persist($unOiseau);
        }

        // Espèce Reptile
        $Reptile= new Espece();
        $Reptile->setNom('Reptile');

        // Race Reptile
        foreach ($reptiles as $reptile) {
            $unReptile = new Race();
            $unReptile->setNom($reptile);
            $unReptile->setEspece($Reptile);

            $manager->persist($unReptile);
        }

        // Espèce Rongeur
        $Rongeur = new Espece();
        $Rongeur->setNom('Rongeur');

        // Race Rongeur
        foreach ($rongeurs as $rongeur) {
            $unRongeur = new Race();
            $unRongeur->setNom($rongeur);
            $unRongeur->setEspece($Rongeur);

            $manager->persist($unRongeur);
        }

        $manager->flush();

        // Annonces
        $annonce = new Annonce();
        $annonce->setTitre('Reproduction berger australien');
        $annonce->setDescription('Bonjour, je cherche à faire reproduire ma jeune chienne de 2 ans avec un autre berger autralien.');
        $annonce->setDatePublication(new \DateTime);
        $annonce->setDateModification(new \DateTime);

        //Utilisateur
        $annonce->setUser($admin);

        //Image
        $image = new Image();
        $image->setUrl('chien.png');

        //Animal
        $animal = new Animal();
        $animal->setNom('Natsu');
        $animal->setSexe(1);
        $animal->setVermifugation(1);
        $animal->setVaccin(1);
        $animal->setPuceTatouage('2544654');
        $animal->setDateNaissance(new \DateTime);

        //Poil
        $randp = array_rand($poils, 2);
        $p = $poils[$randp[0]];
        $poil = $manager->getRepository(Poil::class)->findOneBy(['type' => $p]);
        
        //Couleur
        $randc = array_rand($couleurs, 2);
        $c = $couleurs[$randc[0]];
        $couleur = $manager->getRepository(Couleur::class)->findOneBy(['nom' => $c]);

        //Régime
        $regime = $manager->getRepository(Regime::class)->findOneBy(['nom' => 'Omnivore']);

        //Alimentation
        $randa = array_rand($omnivore, 2);
        $alimentations = [];
        foreach ($randa as $index) {
            $alimentation = $manager->getRepository(Alimentation::class)->findOneBy(['nom' => $omnivore[$index]]);
            if ($alimentation) {
                $alimentations[] = $alimentation;
            }
        }

        //Espece
        $espece = $manager->getRepository(Espece::class)->findOneBy(['nom' => 'Chien']);

        //Race
        $randr = array_rand($chiens, 2);
        $ra = $chiens[$randr[0]];
        $race = $manager->getRepository(Race::class)->findOneBy(['nom' => $ra]);

        //Affectation des données à l'animal
        $animal->setPoil($poil);
        $animal->setCouleur($couleur);
        $animal->setRegime($regime);
        $animal->setEspece($espece);
        $animal->setRace($race);

        foreach ($alimentations as $alimentation) {
            $alimentation->addAnimal($animal);
        }
        
        //Affectation de l'animal à l'annonce
        $annonce->setAnimal($animal);
        $annonce->addImage($image);

        $manager->persist($annonce);

        $manager->flush();
    }
}
