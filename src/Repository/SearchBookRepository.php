<?php

namespace App\Repository;


use App\Entity\SearchBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SearchBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchBook[]    findAll()
 * @method SearchBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchBookRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SearchBook::class);
    }


}
