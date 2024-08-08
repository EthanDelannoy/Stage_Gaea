<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @return CategoryWithCountDTO[]
     */
    public function findAllWithCount(): array{ //Afficher le nombre de recette qu'il y a dans une catégorie
        return $this->createQueryBuilder('c') 
        ->select('NEW App\\DTO\\CategoryWithCountDTO(c.id, c.name, COUNT(c.id))') //selectionne l'id et le nom et compte par l'id
        ->leftJoin('c.recipes', 'r') // il joint la recette a la catégorie
        ->groupBy('c.id') // il groupe par l'id
        ->getQuery() 
        ->getResult(); //il affiche le résultat
    }

    //    /**
    //     * @return Category[] Returns an array of Category objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Category
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
