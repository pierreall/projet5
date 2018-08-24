<?php

namespace App\Repository;

use App\Entity\Ouvrage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ouvrage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ouvrage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ouvrage[]    findAll()
 * @method Ouvrage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OuvrageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ouvrage::class);
    }

//    /**
//     * Our new getAllPosts() method
//     *
//     * 1. Create & pass query to paginate method
//     * 2. Paginate will return a `\Doctrine\ORM\Tools\Pagination\Paginator` object
//     * 3. Return that object to the controller
//     *
//     * @param integer $currentPage The current page (passed from controller)
//     *
//     * @return \Doctrine\ORM\Tools\Pagination\Paginator
//     */
//    public function getAllOuvrages($currentPage = 1)
//    {
//        // Create our query
//        $query = $this->createQueryBuilder('o')
//            ->orderBy('o.created', 'DESC')
//            ->getQuery();
//
//        // No need to manually get get the result ($query->getResult())
//
//        $paginator = $this->paginate($query, $currentPage);
//
//        return $paginator;
//    }
//
//    public function paginate($dql, $page = 1, $limit = 10)
//    {
//        $paginator = new Paginator($dql);
//
//        $paginator->getQuery()
//            ->setFirstResult($limit * ($page - 1)) // Offset
//            ->setMaxResults($limit); // Limit
//
//        return $paginator;
//    }


//    /**
//     * @return Ouvrage[] Returns an array of Ouvrage objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ouvrage
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
