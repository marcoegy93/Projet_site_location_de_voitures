<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Service\Panier\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PanierController
 * @package App\Controller
 * @Route("/panier", name="panier_")
 */
class PanierController extends AbstractController
{
    private PanierService $panierService;

    /**
     * PanierController constructor.
     * @param panierService $panierService
     */
    public function __construct(panierService $panierService)
    {
        $this->panierService = $panierService;
    }

    /**
     * @Route("", name="index")
     * @return Response
     */
    public function index() :Response
    {
        $panier = $this->panierService->getToutlePanier();
        $totalPanier = $this->panierService->getPrixTotal();
        return $this->render('panier/index.html.twig', [
            'elements' => $panier,
            'totalPanier' => $totalPanier
        ]);
    }


    /**
     * @Route("/supprimer/{id}", name="supprimer")
     * @param Vehicule $vehicule
     * @return RedirectResponse
     */
    public function remove(Vehicule $vehicule) :Response
    {
        $this->panierService->supprimer($vehicule->getIdVehicule());
        return $this->redirectToRoute('panier_index');
    }

}
