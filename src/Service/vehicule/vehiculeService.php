<?php

namespace App\Service\vehicule;

use App\Entity\Vehicule;
use App\Entity\Utilisateur;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;

class vehiculeService
{
    private EntityManagerInterface $vehiculeEm;
    private VehiculeRepository $vehiculeRepository;

    public function __construct( EntityManagerInterface $vehiculeEm, VehiculeRepository $vehiculeRepository)
    {
        $this->vehiculeEm = $vehiculeEm;
        $this->vehiculeRepository = $vehiculeRepository;
    }

    public function getVehicules() :array
    {
        return $this->vehiculeRepository->findAll();
    }

    public function ajouter(Vehicule $vehicule)
    {
        $this->vehiculeEm->persist($vehicule);
        $this->vehiculeEm->flush();
    }

    public function supprimer(Vehicule $vehicule)
    {
        $this->vehiculeEm->remove($vehicule);
        $this->vehiculeEm->flush();
    }

    public function QuantiteDispo(Vehicule $vehicule)
    {
        return $this->vehiculeRepository->QuantiteDispo($vehicule->getIdVehicule());
    }

    /**
     * @param Vehicule $vehicule
     * @param int $nb
     */
    public function MiseAJourVehiculeNb(Vehicule $vehicule, int $nb)
    {
        $vehicule->setNb($vehicule->getNb() - $nb);
    }

    public function retourneVehicule(Vehicule $vehicule,Utilisateur $utilisateur)
    {   
        $vehiculesDispo = array();
        $vehiculesLoues = $vehicule->getVehiculesLoues();
        $vehiculesLocation = array();
        $vehicule->setNb($vehicule->getNb() +1);
        for($i=1;$i<=$vehicule->getNb();$i++){
            $vehiculesDispo['vehicule'.$i]= "disponible";
        }
        
        for($i=1;$i<=count($vehiculesLoues);$i++){
            if(array_key_exists("vehicule'.$i", $vehiculesLoues)){
                if($vehiculesLoues['vehicule'.$i] == $utilisateur->getIdUtilisateur()){
                    $vehiculesLoues['vehicule'.$i] = NULL;
                    break;
                }
            }
  
        }
        for($i=1;$i<=count($vehiculesLoues);$i++){
            if(array_key_exists("vehicule'.$i", $vehiculesLoues)){
                if($vehiculesLoues['vehicule'.$i] != NULL){
                    $vehiculesLocation['vehicule'.$i] = $vehiculesLoues['vehicule'.$i];
                }
            }

        }
        $vehicule->setVehiculesDispo($vehiculesDispo);
        $vehicule->setVehiculesLoues( $vehiculesLocation);
    }

    public function revisionVehicule(Vehicule $vehicule,Utilisateur $utilisateur)
    {   
        $vehiculesLoues = $vehicule->getVehiculesLoues();
        $vehiculesLocation = array();
        if($vehicule->getVehiculesEnRevision()==NULL){
            $nbvehiculesRevision = 0;
        }else{
            $vehiculesRevision = $vehicule->getVehiculesEnRevision();
            $nbvehiculesRevision = count($vehicule->getVehiculesEnRevision());
        }
        for($i=1;$i<=$nbvehiculesRevision+1;$i++){
            $vehiculesRevision['vehicule'.$i]= "en-revision";
        }
        for($i=1;$i<=count($vehiculesLoues);$i++){
            if(array_key_exists("vehicule'.$i", $vehiculesLoues)){
                if($vehiculesLoues['vehicule'.$i] == $utilisateur->getIdUtilisateur()){
                    $vehiculesLoues['vehicule'.$i] = NULL;
                    break;
                }
            }
  
        }
        for($i=1;$i<=count($vehiculesLoues);$i++){
            if(array_key_exists("vehicule'.$i", $vehiculesLoues)){
                if($vehiculesLoues['vehicule'.$i] != NULL){
                    $vehiculesLocation['vehicule'.$i] = $vehiculesLoues['vehicule'.$i];
                }
            }

        }
        // for($i=1;$i<= count($vehiculesRevision)+1;$i++){
        //     $vehiculesRevision['vehicule'.$i] = "en-revision";
        // }
        $vehicule->setVehiculesEnRevision( $vehiculesRevision);
        $vehicule->setVehiculesLoues( $vehiculesLocation);
    }
}