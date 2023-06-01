<?php

namespace App\Controller;

use App\Entity\Poil;
use App\Entity\Race;
use App\Entity\Image;
use App\Entity\Espece;
use App\Entity\Regime;
use App\Entity\Annonce;
use App\Entity\Couleur;
use App\Data\SearchData;
use App\Form\SearchType;
use App\Form\AnnonceType;
use App\Entity\Alimentation;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnonceController extends AbstractController
{
    #[Route('/annonce', name: 'app_annonce')]
    public function index(AnnonceRepository $repository, UserRepository $userRepo, Request $request): Response
    {
        // Crée une nouvelle instance de la classe SearchData
        $data = new SearchData();
        // Crée le formulaire en utilisant la classe SearchType et l'instance $data
        $form = $this->createForm(SearchType::class, $data);
        // Gère la soumission du formulaire
        $form->handleRequest($request);
        // Appelle la méthode findSearch du repository pour récupérer les annonces correspondant aux critères de recherche
        $annonces = $repository->findSearch($data);

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/regime/fetch/{regime}', name: 'app_annonce_fetch_regime')]
    public function fetchByRegime(string $regime = "" , EntityManagerInterface $entityManager, SerializerInterface $serializer):Response
    {
        // Recherche le régime correspondant à l'identifiant fourni
        $regime = $entityManager->getRepository(Regime::class)->find($regime);

        // Récupère les alimentations associées au régime sélectionné
        $alimentations = $entityManager->getRepository(Alimentation::class)->findByRegime($regime);
        
        // Retourne les alimentations au format JSON
        return new JsonResponse($serializer->serialize($alimentations, 'json', ['groups' => ['list_alimentations']]));
    }

    #[Route('/espece/fetch/{espece}', name: 'app_annonce_fetch_espece')]
    public function fetchByEspece(string $espece = "" , EntityManagerInterface $entityManager, SerializerInterface $serializer):Response
    {
        // Recherche l'espèce correspondant à l'identifiant fourni
        $espece = $entityManager->getRepository(Espece::class)->find($espece);

        // Récupère la race associée à l'espèce sélectionnée
        $races = $entityManager->getRepository(Race::class)->findByEspece($espece);
        
        // Retourne les races au format JSON
        return new JsonResponse($serializer->serialize($races, 'json', ['groups' => ['list_races']]));
    }


    #[Route('/annonce/create', name: 'app_annonce_create')]
    public function createAnnonce(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérifie que l'utilisateur est connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login', ['redirected' => true]);
        }

        // Crée une nouvelle instance de la classe Annonce
        $annonce = new Annonce();
        // Crée le formulaire en utilisant la classe AnnonceType et l'instance $annonce
        $form = $this->createForm(AnnonceType::class, $annonce);
        // Gère la soumission du formulaire
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Définit la date de publication et de modification de l'annonce comme la date et l'heure actuelles
            $annonce->setDatePublication(new \DateTime());
            $annonce->setDateModification(new \DateTime());
            // Associe l'utilisateur actuellement connecté à l'annonce
            $annonce->setUser($this->getUser());

            // Récupère l'animal sélectionné dans le formulaire
            $animal = $form->get('animal')->getData();
            $annonce->setAnimal($animal);

            // Récupère les images transmises dans le formulaire
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                // Génère un nouveau nom de fichier pour chaque image
                $url = $image->getClientOriginalName();
                // Déplace le fichier dans le dossier des images
                $image->move(
                    $this->getParameter('images_directory'),
                    $url
                );

                // Crée une nouvelle instance de l'entité Image
                $newImage = new Image();
                $newImage->setUrl($url);

                // Persiste explicitement chaque entité Image
                $entityManager->persist($newImage);

                // Ajoute l'image à la collection d'images de l'annonce
                $annonce->addImage($newImage);
            }

            // Persiste l'annonce dans la base de données
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('app_annonce', ['id' => $annonce->getId()]);
        }

        return $this->render('annonce/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/annonce/delete/id/{id}', name: 'app_annonce_delete_image', methods: ['DELETE'])]
    public function deleteImage(Image $image, Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        // Vérifie si le jeton CSRF est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            // Récupère le nom de l'image
            $nom = $image->getUrl();
            // Supprime le fichier correspondant à l'image
            unlink($this->getParameter('images_directory').'/'.$nom);

            // Supprime l'entrée de l'image de la base de données
            $entityManager->remove($image);
            $entityManager->flush();

            // Retourne une réponse JSON indiquant la réussite de l'opération
            return new JsonResponse(['success' => 1]);
        }else{
            // Retourne une réponse JSON avec une erreur et un code de statut 400 (Bad Request)
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

    #[Route('/annonce/read/id/{id}', name: 'app_read_annonce')]
    public function index_id(Annonce $annonce, AnnonceRepository $repository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Crée le formulaire en utilisant la classe AnnonceType et l'instance $annonce
        $form = $this->createForm(AnnonceType::class, $annonce);
        // Gère la soumission du formulaire
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Persiste les changements dans la base de données
            $entityManager->flush();
            $id = $annonce->getId();

            // Récupère les nouvelles images transmises dans le formulaire
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                $url = $image->getClientOriginalName();
                $image->move(
                    $this->getParameter('images_directory'),
                    $url
                );
                
                // Crée une nouvelle instance de l'entité Image
                $newImage = new Image();
                $newImage->setUrl($url);

                // Persiste explicitement chaque entité Image
                $entityManager->persist($newImage);
                
                // Ajoute l'image à la collection d'images de l'annonce
                $annonce->addImage($newImage);
            }
            // Si aucune nouvelle image n'a été téléchargée, ne pas ajouter d'images supplémentaires
            if (count($images) == 0) {
                $entityManager->persist($annonce);
                $entityManager->flush();
            }
            
            $entityManager->persist($annonce);
            $entityManager->flush();
        }

        return $this->render('annonce/id.html.twig', [
            'form' => $form->createView(),
            'annonce' => $annonce
        ]);
    }

    #[Route('/annonce/{id}/delete', name: 'app_annonce_delete')]
    public function deleteAnnonce(Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
        // Supprime l'annonce de la base de données
        $entityManager->remove($annonce);
        $entityManager->flush();

        return $this->redirectToRoute('app_mes_annonces');
    }

    #[Route('/annonce/{id}/edit', name: 'app_annonce_edit')]
    public function editAnnonce(Request $request, Annonce $annonce, EntityManagerInterface $entityManager): Response
    {
        // Crée le formulaire en utilisant la classe AnnonceType et l'instance $annonce
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Persiste les changements dans la base de données
            $entityManager->flush();

            return $this->redirectToRoute('app_annonce', ['id' => $annonce->getId()]);
        }

        return $this->render('annonce/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/annonce/mes_annonces', name: 'app_mes_annonces')]
    public function mesAnnonces(AnnonceRepository $repository, Request $request): Response
    {
        // Récupère toutes les annonces associées à l'utilisateur connecté
        $annonces = $repository->findBy(['user' => $this->getUser()]);

        return $this->render('annonce/mes_annonces.html.twig', [
            'annonces' => $annonces,
        ]);
    }

    #[Route('/annonce/alimentations/{id}', name: 'app_annonce_alimentations', methods: ['GET'])]
    public function getAlimentationsByRegime(Regime $regime): JsonResponse
    {
        // Récupère toutes les alimentations associées au régime spécifié
        $alimentations = $regime->getAlimentations()->toArray();

        // Retourne une réponse JSON contenant les alimentations
        return new JsonResponse($alimentations);
    }

}

