<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }

    public function TouteslesFactures(): array
    {
        return $this->createQueryBuilder('f')
            ->innerJoin('f.ide', 'e')
            ->innerJoin('f.idv', 'v')
            ->addSelect('e')
            ->addSelect('v')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function TouteslesFacturesDunClient(int $idUtilisateur): array
    {
        return $this->createQueryBuilder('f')
            ->innerJoin('f.ide', 'e')
            ->innerJoin('f.idv', 'v')
            ->andWhere('f.ide= :id')
            ->setParameter('id', $idUtilisateur)
            ->addSelect('e')
            ->addSelect('v')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function ToutesLesFacturesDunVehicule(int $idVehicule): array
    {
        return $this->createQueryBuilder('f')
            ->innerJoin('f.idv', 'v')
            ->andWhere('f.idv = :id')
            ->setParameter('id', $idVehicule)
            ->select('f')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }
}