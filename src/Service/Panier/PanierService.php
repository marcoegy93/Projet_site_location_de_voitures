<?php

namespace App\Service\Panier;

use App\Repository\VehiculeRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService {

    private SessionInterface $session;
    private VehiculeRepository $vehiculeRepository;
    private array $infosPanier;

    public function __construct(SessionInterface $session, VehiculeRepository $vehiculeRepository)
    {
        $this->session = $session;
        $this->vehiculeRepository = $vehiculeRepository;
        $this->infosPanier = [];
    }

    public function ajouter(int $id, array $OptionsLocation, int $nb)
    {
        $panier = $this->session->get('panier', []);
        $DateD = $OptionsLocation['DateD'];
        $DateF = $OptionsLocation['DateF'];
        $DateFtmp = clone $DateD;
        $DateFtmp->modify('+1 month');
        if($DateF==NULL){
            $OptionsLocation['DateF']= $DateFtmp;
        }
        
        //$nbDays = (int)date('t');
        if($DateF) {
            if($DateF==$DateD){
                $nbDays = 1;
            }else{
                $nbDays = $DateD->diff($DateF)->days;
            }
            
        }else{
            $nbDays = $DateD->diff($DateFtmp)->days;
        }
        $panier[$id] = [$id, $OptionsLocation, $nb, $nbDays];

        $this->session->set('panier', $panier);
    }

    public function supprimer(int $id)
    {
        $panier = $this->session->get('panier', []);
        if(!empty($panier)){
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }

    public function getToutlePanier() :array
    {
        $panier = $this->session->get('panier', []);
        foreach ($panier as $id){
            $this->infosPanier[] = [
                'item' => $this->vehiculeRepository->find($id[0]),
                'OptionsLocation' => $id[1],
                'nb' => $id[2],
                'nbDays' => $id[3]
            ];
        }

        return $this->infosPanier;
    }

    public function getPrixTotal() : float
    {
        $totalItems = 0;
        foreach ($this->infosPanier as $infoPanier){
            $totalItems+= ($infoPanier['item']->getPrix()*$infoPanier['nbDays'])*$infoPanier['nb'];
        }
        return $totalItems;
    }

    public function viderLePanier()
    {
        $this->session->set('panier', []);
        $this->infosPanier = [];
    }

}