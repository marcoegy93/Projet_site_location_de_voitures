<?php

namespace App\Service\utilisateur;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;

class utilisateurService
{
    private UtilisateurRepository $utilisateurRepository;
    private EntityManagerInterface $entityManager;

    /**
     * utilisateurService constructor.
     * @param $utilisateurRepository
     * @param $entityManager
     */
    public function __construct(utilisateurRepository $utilisateurRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $utilisateurRepository;
        $this->entityManager = $entityManager;
    }

    public function getUtilisateur(int $id): Utilisateur
    {
        return $this->utilisateurRepository->find($id);
    }
    public function getUtilisateurs() :array
    {
        return $this->utilisateurRepository->findAll();
    }
}