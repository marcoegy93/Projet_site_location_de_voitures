<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Service\vehicule\vehiculeService;
use App\Service\Panier\PanierService;
use App\Service\Facture\FactureService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

/**
 * Class FactureController
 * @package App\Controller
 * @Route("/facture", name="facture_")
 */
class FactureController extends AbstractController
{
    private PanierService $panierService;
    private FactureService $factureService;
    private vehiculeService $vehiculeService;
    private Security $security;

    /**
     * FactureController constructor.
     * @param PanierService $panierService
     * @param FactureService $factureService
     * @param VehiculeService $vehiculeService
     * @param Security $security
     */
    public function __construct(PanierService $panierService, FactureService $factureService, VehiculeService $vehiculeService, Security $security)
    {
        $this->panierService = $panierService;
        $this->factureService = $factureService;
        $this->vehiculeService = $vehiculeService;
        $this->security = $security;
    }

    /**
     * @Route("/nouvelle", name="nouvelle")
     * @return Response
     */
    public function creerFacture() :Response
    {
        $commande = $this->panierService->getToutlePanier();
        foreach ($commande as $element){
            $OptionsLocation = $element['OptionsLocation'];
        
            $nb = $element['nb'];
            $vehicule = $element['item'];
            for($i = 0; $i < $nb; $i++){
                $this->factureService->creerFacture($this->getUser(), $vehicule, $OptionsLocation);
            }
            $this->vehiculeService->MiseAJourVehiculeNb($vehicule, $nb);
        }
            $vehiculesDispo = array();
            $vehiculesLoues = array();
            for($i=1;$i<=$vehicule->getNb();$i++){
                $vehiculesDispo['vehicule'.$i]= "disponible";
            }
            if($vehicule->getVehiculesLoues()==NULL){
                $nbVehiculesLoues = 0;
                $vehicule->setVehiculesLoues(array());
            }else{
                $nbVehiculesLoues = count($vehicule->getVehiculesLoues());
            }
            
            for($i=$nbVehiculesLoues+1;$i<=$nbVehiculesLoues+$nb;$i++){

                $vehiculesLoues['vehicule'.$i]= $this->getUser()->getIdUtilisateur();
            }
            $vehiculesLocationCombine = array_merge($vehicule->getVehiculesLoues(),$vehiculesLoues);
            $vehicule->setVehiculesDispo($vehiculesDispo);
            $vehicule->setVehiculesLoues( $vehiculesLocationCombine);
            $this->factureService->flushFacture();
            $this->panierService->viderLePanier();

        return $this->redirectToRoute('vehicules');
    }


    /**
     * @Route("/payer-{id}", name="payer")
     * @param Facture $facture
     * @return Response
     */
    public function PayerFacture(Facture $facture) :Response
    {

        $vehicule = $facture->getIdv();

        $nbDays = $facture->getDateD()->diff($facture->getDateF())->days;
        if($nbDays == 0){
            ++$nbDays;
        }

        return $this->render('panier/panier.paye.html.twig', [
            'facture' => $facture,
            'vehicule' => $vehicule,
            'nbDays' => $nbDays
        ]);
    }


    /**
     * @Route("/miseAJour/{id}", name="miseAJour")
     * @param Facture $facture
     * @return Response
     */
    public function miseAJourFacture (Facture $facture) :Response
    {
        $this->factureService->payerFacture($facture);

        return $this->redirectToRoute('espace_utilisateur_client_locations', [
            'id' => $facture->getIde()->getIdUtilisateur()
        ]);

    }
}
