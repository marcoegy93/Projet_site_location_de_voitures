<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Utilisateur;
use App\Entity\Vehicule;
use App\Service\vehicule\vehiculeService;
use App\Service\utilisateur\utilisateurService;
use App\Service\Facture\FactureService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 * Class EspaceUtilisateurController
 * @package App\Controller
 * @Route("/espace-utilisateur", name="espace_utilisateur_")
 */
class EspaceUtilisateurController extends AbstractController
{
    private utilisateurService $utilisateurService;
    private vehiculeService $vehiculeService;
    private FactureService $factureService;

    public function __construct(utilisateurService $utilisateurService, vehiculeService $vehiculeService,FactureService $factureService)
    {
        $this->utilisateurService = $utilisateurService;
        $this->vehiculeService = $vehiculeService;
        $this->factureService = $factureService;
    }



    /**
     * tableau de bord du client
     * @Route("", name="index")
     * @return Response
     */
    public function index() :Response
    {
        /**
         * @var Utilisateur $client
         */
        $client = $this->getUser();
        $infos = $this->factureService->getTableauBord($client, 'ROLE_CLIENT');
        return $this->render("espace_utilisateur/client/tableau_bord_client.html.twig", [
            'infos' => $infos
        ]);
    }




    /**
     * Les véhicules en cours de location
     * @Route("/client/locations/{id}", name="client_locations")
     * @param Utilisateur $client
     * @return Response
     */
    public function locations(Utilisateur $client) :Response
    {
        $factures = $this->factureService->ToutesLesfacturesDunClient($client);
        $facturesformates= array();
        foreach ($factures as $facture) {
            $vehicule = $facture->getIdv();
            array_push($facturesformates, [$facture, $vehicule]);
        }
        return $this->render('espace_utilisateur/client/locations.html.twig', [
            'factures' => $facturesformates,
            'id' => $client->getIdUtilisateur()
        ]);
    }



    /**
     * Show all factures of the client
     * @Route("/client/factures/{id}", name="client_factures")
     * @param Utilisateur $client
     * @return Response
     */
    public function facturesDuClient(Utilisateur $client) :Response
    {
        $factures = $this->factureService->ToutesLesfacturesDunClient($client);
        $facturesFormates = array();
        foreach ($factures as $facture) {
            $vehicule = $facture->getIdv();
            $renter =  $facture->getIde();
            array_push($facturesFormates, [$facture, $vehicule, $renter]);
        }
        return $this->render('espace_utilisateur/client/factures.html.twig', [
            'factures' => $facturesFormates
        ]);
    } 


    /**
     * @Route("/vehicule/retourne/{id}", name="retourne")
     * @param Facture $facture
     * @return Response
     */
    public function retourneVehicule(Facture $facture) :Response
    {
        $vehicule = $facture->getIdv();
        $utilisateur = $facture->getIde();
        $this->vehiculeService->retourneVehicule($vehicule,$utilisateur);
        $facture->setRetourne(true);
        $this->vehiculeService->ajouter($vehicule);
        $this->addFlash('message', "Le véhicule à bien été rendu");
        return $this->redirectToRoute('espace_utilisateur_client_factures', [
            'id' => $facture->getIde()->getIdUtilisateur()
        ]);
    }

    /**
     * @Route("/vehicule/revision/{id}", name="revision")
     * @param Facture $facture
     * @return Response
     */
    public function revisionVehicule(Facture $facture) :Response
    {
        $vehicule = $facture->getIdv();
        $utilisateur = $facture->getIde();
        $this->vehiculeService->revisionVehicule($vehicule,$utilisateur);
        $facture->setRevision(true);
        $this->vehiculeService->ajouter($vehicule);
        $this->addFlash('message', "Le véhicule à bien été rendu");
        return $this->redirectToRoute('espace_utilisateur_client_factures', [
            'id' => $facture->getIde()->getIdUtilisateur()
        ]);
    }
}