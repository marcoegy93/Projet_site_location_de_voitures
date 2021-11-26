<?php


namespace App\Service\Facture;

use DateTime;
use App\Entity\Vehicule;
use App\Entity\Utilisateur;
use DateTimeInterface;
use App\Entity\Facture;
use App\Service\vehicule\vehiculeService;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class FactureService
{
    private EntityManagerInterface $entityManager;
    private FactureRepository $Facturerepository;
    private vehiculeService $vehiculeService;
    private const NB_VIP_CAR = 10;
    private const NB_JOUR_VIP= 35;
    private const REDUCE_PCT = 0.1;

    /**
     * FactureService constructor.
     * @param EntityManagerInterface $entityManager
     * @param FactureRepository $factureRepository
     * @param VehiculeService $vehiculeService
     */
    public function __construct(EntityManagerInterface $entityManager, FactureRepository $Facturerepository, vehiculeService $vehiculeService)
    {
        $this->entityManager = $entityManager;
        $this->Facturerepository = $Facturerepository;
        $this->vehiculeService = $vehiculeService;
    }

    public function getTableauBord(?Utilisateur $utilisateur, string $role) : array
    {
        $factures = array();
        $vehicules=array();
        if($utilisateur){
            if($role == 'ROLE_LOUEUR'){
                $factures = $this->Facturerepository->ToutesLesfactures();
                $vehicules = $this->vehiculeService->getVehicules();
            }
            else {
                $factures = $this->Facturerepository->ToutesLesfacturesDunClient($utilisateur->getIdUtilisateur());
            }
        }
        else {
            $factures = $this->Facturerepository->ToutesLesfactures();
        }
        $nbVehiculesLoues = $nbVehiculesRevisions = $nbAvailableCars =$nbVehiculesRetournes =$nbVehiculesRevision =$totalAmountPaid = $nbUnpaid = $montantLocationsMoisCourant = 0;

        foreach ($factures as $facture){
            ++$nbVehiculesLoues;
            if($facture->getEtatR()){
                $totalAmountPaid += $facture->getValeur();
            }
            else {
                ++$nbUnpaid;
            }
            if($facture->getRetourne()){
                $nbVehiculesRetournes+= $facture->getRetourne();
            }
            if($facture->getRevision()){
                $nbVehiculesRevisions+= $facture->getRevision();
            }
            if(date('m',strtotime($facture->getDateD()->format('Y/m/d'))) == date('m')){
                $montantLocationsMoisCourant += $facture->getValeur();
            }
        }

    foreach($vehicules as $vehicule){
        $nbAvailableCars+= $vehicule->getNb();
    }
        return array($nbVehiculesLoues, $nbAvailableCars, $totalAmountPaid, $nbUnpaid, $montantLocationsMoisCourant,$nbVehiculesRetournes,$nbVehiculesRevisions);
    }

    public function creerfacture(UserInterface $utilisateur, Vehicule $vehicule, array $OptionsLocation)
    {
        $reduction = false;
        $dateFin = false;
        $estPaye = false;

        $utilisateur_tmp = $utilisateur;
        /**
         * @var Utilisateur $utilisateur_tmp
         */
        $factures = $this->ToutesLesfacturesDunClient($utilisateur_tmp);
        $nbRent = count($factures);

        if($nbRent > self::NB_VIP_CAR  ){
            $reduction = true;
        }

        $dateF=clone $OptionsLocation['DateD'];
        $dateF->modify("+1 month");
        $nbDays = (int)date('t');
        if($OptionsLocation['DateF']){
            $dateFin = true;
            /**
             * @var DateTimeInterface $date
             */
            if($OptionsLocation['DateF']==$OptionsLocation['DateD']){
                $nbDays = 1;
            }else{
                $nbDays = $OptionsLocation['DateD']->diff($OptionsLocation['DateF'])->days;
            }


        }else{
            $nbDays = $OptionsLocation['DateD']->diff($dateF)->days;
        }
        if($nbDays >= self::NB_JOUR_VIP){
            $reduction = true;
        }
        $facture = new Facture();
        $facture->setIdv($vehicule)
            ->setIde($utilisateur)
            ->setValeur($reduction ? ($vehicule->getPrix()*$nbDays*(1-self::REDUCE_PCT)) :
                $vehicule->getPrix()*$nbDays)
            ->setDateD($OptionsLocation['DateD']);
        if($dateFin){
            $facture->setDateF($OptionsLocation['DateF']);
        }else{
            $facture->setDateF($dateF);
        }
        $facture->setEtatR($estPaye);

        $this->entityManager->persist($facture);
    }

    public function supprimerfacture (Facture $facture)
    {
        $this->entityManager->remove($facture);
    }

    public function flushfacture()
    {
        $this->entityManager->flush();
    }

    public function ToutesLesfactures() :array
    {
        return $this->Facturerepository->TouteslesFactures();
    }

    public function ToutesLesfacturesDunClient(Utilisateur $client) :array
    {
        return $this->Facturerepository->ToutesLesfacturesDunClient($client->getIdUtilisateur());
    }

    public function ToutesLesFacturesDunVehicule(Vehicule $vehicule): bool
    {
        return count($this->Facturerepository->ToutesLesFacturesDunVehicule($vehicule->getIdVehicule())) > 0;
    }

    public function payerfacture(Facture $facture)
    {
        $facture->setEtatR(true);
        $this->entityManager->flush();
    }

}