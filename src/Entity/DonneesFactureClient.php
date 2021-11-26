<?php


namespace App\Entity;


class DonneesFactureClient
{
    private Utilisateur $utilisateur;

    /**
     * @return mixed
     */
    public function getUtilisateur() :Utilisateur
    {
        return $this->utilisateur;
    }

    /**
     * @param mixed $utilisateur
     */
    public function setUtilisateur($utilisateur): void
    {
        $this->utilisateur = $utilisateur;
    }
}