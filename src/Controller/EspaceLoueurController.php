<?php


namespace App\Controller;

use App\Entity\DonneesFactureClient;
use App\Entity\Vehicule;
use App\Entity\Utilisateur;
use App\Form\ModifVehiculeFormType;
use App\Form\FactureClientFormType;
use App\Service\vehicule\vehiculeService;
use App\Service\utilisateur\utilisateurService;
use App\Service\Facture\FactureService;
use App\Service\UploadPhoto\uploadPhotoService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class EspaceLoueurController
 * @package App\Controller
 * @Route("/espace_utilisateur/loueur", name="espace_utilisateur_loueur_")
 * @IsGranted("ROLE_LOUEUR")
 */
class EspaceLoueurController extends AbstractController
{
    private utilisateurService $utilisateurService;
    private VehiculeService $vehiculeService;
    private FactureService $factureService;

    public function __construct(utilisateurService $utilisateurService, vehiculeService $vehiculeService, FactureService $factureService)
    {
        $this->utilisateurService = $utilisateurService;
        $this->vehiculeService = $vehiculeService;
        $this->factureService = $factureService;
    }

    /**
     * @Route("", name="index")
     * @return Response
     */
    public function index(): Response
    {
        /**
         * @var Utilisateur $loueur
         */
        $loueur = $this->getUser();
        $infos = $this->factureService->getTableauBord($loueur, 'ROLE_LOUEUR');
        return $this->render("espace_utilisateur/loueur/tableau_bord_loueur.html.twig", [
            'infos' => $infos
        ]);
    }

    /**
     * @Route("/vehicules/{id}", name="vehicules")
     * @return Response
     */
    public function MesVehicules() :Response
    {
        $vehicules = $this->vehiculeService->getVehicules();
        return $this->render("espace_utilisateur/loueur/vehicules.html.twig", [
            'vehicules' => $vehicules
        ]);
    }

    private function facturefiltre(array $factures) :array
    {
        $facturefiltre = array();
        foreach ($factures as $facture){
            $vehicule = $facture->getIdv();
            $entreprise = $facture->getIde();
            array_push( $facturefiltre, [$facture, $vehicule, $entreprise]);
        }
        return $facturefiltre;
    }

    /**
     * Show the rented cars of a renter
     * @Route("/loues/vehicules", name="vehicules_loues")
     * @param Request $request
     * @return Response
     */
    public function vehiculesLoues(Request $request) :Response
    {
        $donneesClientFacture = new DonneesFactureClient();
        $factureClientForm = $this->createForm(FactureClientFormType::class, $donneesClientFacture);

        $factureClientForm->handleRequest($request);
        if($factureClientForm->isSubmitted() && $factureClientForm->isValid()){
            $factures = $this->factureService->ToutesLesfacturesDunClient($donneesClientFacture->getUtilisateur());
            $facturesfiltre = $this->facturefiltre($factures);
        }
        else {

            $factures = $this->factureService->ToutesLesfactures();
            $facturesfiltre = $this->facturefiltre($factures);
        }

        return $this->render('espace_utilisateur/loueur/vehiculesLoues.html.twig', [
            'factures' =>  $facturesfiltre,
            'form' => $factureClientForm->createView()
        ]);
    }


    /**
     * @Route("vehicule/modification/{id}", name="vehicule_modification")
     * @param Request $request
     * @param uploadPhotoService $photoUploader
     * @param Vehicule $vehicule
     * @return Response
     */
    public function modifierVehicule(Request $request, uploadPhotoService $photoUploader, Vehicule $vehicule) :Response
    {
        $form = $this->createForm(ModifVehiculeFormType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $vehiculeNb = $form->get('nb')->getData();
            $vehicule->setNb($vehiculeNb);
            $this->vehiculeService->ajouter($vehicule);
            $this->addFlash('message',"Votre véhicule à bien été modifié");

            return $this->redirectToRoute('espace_utilisateur_loueur_vehicules', [
                'id' => $this->getUser()->getIdUtilisateur()
            ]);

        }

        return $this->render("vehicules/modif.vehicule.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /** The renter can remove a car from his list
     * @Route("/vehicule/supprimer/{id}", name="vehicule_supprimer")
     * @param Vehicule $vehicule
     * @return Response
     */
    public function supprimerVehicule(Vehicule $vehicule) :Response
    {
        if($this->factureService->ToutesLesFacturesDunVehicule($vehicule)){
            return $this->redirectToRoute('espace_utilisateur_vehicules_loues',[
                'id' => $this->getUser()->getId()
            ]);
        }
        $this->vehiculeService->supprimer($vehicule);
        $this->addFlash('message', "Votre véhicule a bien été supprimé");
        return $this->redirectToRoute("espace_utilisateur_vehicules_loues", [
            'id' => $this->getUser()->getIdUtilisateur()
        ]);
    }

}
