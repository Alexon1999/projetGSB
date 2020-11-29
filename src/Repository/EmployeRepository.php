<?php

namespace App\Repository;

use App\Entity\Employe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employe|null findByLogin($login, $lockMode = null, $lockVersion = null)
 * @method Employe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employe[]    findAll()
 * @method Employe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employe::class);
    }


    // + getOneOrNullResult() -> return an object ou null
    // + getResult() -> return an array

    // /**
    //  * @return Employe|null Returns an employe object
    //  */
    public function findByLogin($value): ?Employe
    {
        return $this->createQueryBuilder('employe')
            ->setParameter('val', $value)
            ->where('employe.login = :val')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByLoginAndMdp($login, $mdp): ?Employe
    {
        return $this->createQueryBuilder('employe')
            ->setParameter('login', $login)
            ->setParameter('mdp', $mdp)
            ->where('employe.login = :login AND employe.mdp = :mdp')
            ->getQuery()
            ->getOneOrNullResult();
    }



    /*
    public function findOneBySomeField($value): ?Employe
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
