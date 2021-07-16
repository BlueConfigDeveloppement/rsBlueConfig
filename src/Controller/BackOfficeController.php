<?php

namespace App\Controller;

use App\Services\BreadcrumdServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/back_office')]
class BackOfficeController extends AbstractController
{
    private $breadcrumbServices;

    public function __construct(BreadcrumdServices $breadcrumbServices)
    {
        $this->breadcrumbServices = $breadcrumbServices;
    }

    #[Route('/', name: 'back_office')]
    public function index(): Response
    {

        // Génération Breadcrump -> Sercices
        $this->breadcrumbServices->createdRouteLibelle(['','Dashboard'], 'Accueil', 'Page Accueil');
        $breadcrumb = $this->breadcrumbServices->createdBreadcrumbAdmin();

        return $this->render('back_office/index.html.twig', [
            'controller_name' => 'BackOfficeController',
            'breadcrumd' => $breadcrumb,
        ]);
    }
}
