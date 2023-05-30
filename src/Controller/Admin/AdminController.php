<?php

namespace App\Controller\Admin;

use App\Entity\Poil;
use App\Entity\Race;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Animal;
use App\Entity\Espece;
use App\Entity\Regime;
use App\Entity\Annonce;
use App\Entity\Couleur;
use App\Entity\Alimentation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Controller\DashboardControllerInterface;

class AdminController extends AbstractDashboardController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();
        return $this->render('admin/index.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Bete De Rencontre');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-dashboard');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-users', User::class);
        yield MenuItem::linkToCrud('Annonces', 'fa-solid fa-signs-post', Annonce::class);
        yield MenuItem::linkToCrud('Images', 'fa-solid fa-image', Image::class);
        yield MenuItem::linkToCrud('Animaux', 'fas fa-paw', Animal::class);
        yield MenuItem::linkToCrud('Poil', 'fas fa-feather', Poil::class);
        yield MenuItem::linkToCrud('Couleur', 'fas fa-tint', Couleur::class);
        yield MenuItem::linkToCrud('Espece', 'fas fa-dog', Espece::class);
        yield MenuItem::linkToCrud('Race', 'fas fa-dog-leashed', Race::class);
        yield MenuItem::linkToCrud('Regime', 'fas fa-bone', Regime::class);
        yield MenuItem::linkToCrud('Alimentation', 'fas fa-carrot', Alimentation::class);
    }
}
