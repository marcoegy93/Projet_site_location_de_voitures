<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Vehicule;
use App\Form\NouveauVehiculeFormType;
use App\Service\Panier\PanierService;
use Symfony\Component\Form\FormError;
use App\Form\LocationVehiculeFormType;
use App\Service\Facture\FactureService;
use App\Service\vehicule\vehiculeService;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\UploadPhoto\uploadPhotoService;
use App\Service\utilisateur\utilisateurService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class VehiculesController extends AbstractController
{
    private vehiculeService $vehiculeService;
    private FactureService $factureService;
    private UtilisateurService $userService;

    public function __construct(VehiculeService $vehiculeService,
                                FactureService $factureService,
                                UtilisateurService $utilisateurService)
    {
        $this->vehiculeService = $vehiculeService;
        $this->factureService = $factureService;
        $this->utilisateurService = $utilisateurService;
    }

    /**
     * @Route("/vehicules", name="vehicules")
     */
    public function index(): Response
    {
        $vehicules=$this->vehiculeService->getVehicules();
        
        return $this->render('vehicules/index.html.twig', [
            'vehicules' => $vehicules
        ]);
    }

        /**
     * @Route("/nouveau_vehicule", name="nouveau_vehicule")
     * @param Request $request
     * @param uploadPhotoService $photoUploader
     * @return Response
     */
    public function ajouterNouveauVehicule(Request $request, uploadPhotoService $photoUploader) :Response
    {

        $vehicule = new Vehicule();
        $form = $this->createForm(NouveauVehiculeFormType::class, $vehicule);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $vehiculeFile = $form->get('photo')->getData();
            $vehiculeType= $form->get('type')->getData();
            $vehiculeNb= $form->get('nb')->getData();
            $caracteristiques = array();
            $vehiculesDispo= array();

            $caracteristiques['categorie'] = $form->get('categorie')->getData();
            $caracteristiques['energie'] = $form->get('energie')->getData();
            $caracteristiques['moteur'] = $form->get('moteur')->getData();
            $caracteristiques['boite'] = $form->get('boite')->getData();
            $caracteristiques['nb_portes'] = $form->get('nb_portes')->getData();
            $vehicule->setCaract($caracteristiques);

            if ($vehiculeFile) {
                $carFileName = $photoUploader->upload($vehiculeFile);
                $vehicule->setPhoto($carFileName);
            }
            $vehicule->setType($vehiculeType);
            for($i=1;$i<=$vehiculeNb;$i++){
                $vehiculesDispo['vehicule'.$i]= "disponible";
                
            }
            $vehicule->setVehiculesDispo($vehiculesDispo);
            
            $this->vehiculeService->ajouter($vehicule);
            
            return $this->redirectToRoute('espace_utilisateur_loueur_vehicules', [
                'id' => $this->getUser()->getIdUtilisateur()
            ]);
        }

        return $this->render('vehicules\nouveau.vehicule.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/vehicule/{id}", name="vehicule_view")
     * @param Vehicule $vehicule
     * @return Response
     */
    public function detailVehicule(Vehicule $vehicule) :Response
    {
        return $this->render('vehicules/vehicule.view.html.twig', [
            'vehicule' => $vehicule
        ]);
    }

    /**
     * @Route("/vehicule/loueur/{id}", name="vehicule_location")
     * @param Vehicule $vehicule
     * @param PanierService $PanierService
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function LouerVehicule(Vehicule $vehicule, Request $request,PanierService $PanierService,ValidatorInterface $validator) :Response
    {
        $facture = new Facture();
        $quantity =(int)$this->vehiculeService->QuantiteDispo($vehicule)[0]['nb'];
        $form = $this->createForm(LocationVehiculeFormType::class, $facture);
        $form->handleRequest($request);
        $errors = $validator->validate($facture);
        
        if($form->isSubmitted() && $form->isValid()){
            $data= $form->getData();
            $nb = (int)$form->get('nb')->getData();
            if($nb > $quantity){
              $form->get('nb')->addError(new FormError("La quantité en stock est inférieure à la quantité rentrée"));
            }
            else {
                if($data->getDateF() == NULL){
                    $OptionsLocation = [
                        'DateD' => $form->get('DateD')->getData(),
                        'DateF' => $form->get('DateF')->getData(),
                        'nb' => (int)$form->get('nb')->getData(),
                    ];
                }else{
                    $OptionsLocation = [
                        'DateD' => $form->get('DateD')->getData(),
                        'DateF' => $form->get('DateF')->getData(),
                        'nb' => (int)$form->get('nb')->getData(),
                    ];
                }
                $PanierService->ajouter($vehicule->getIdVehicule(), $OptionsLocation, $OptionsLocation['nb']);
    
                $this->addFlash('notif', "Votre commande à été ajoutée au panier.");
    
                return $this->redirectToRoute('vehicules');
            }
        }

        return $this->render('vehicules/vehicules.location.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }




}
