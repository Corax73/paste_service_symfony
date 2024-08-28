<?php

namespace App\Repository;

use App\Entity\Paste;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Paste>
 */
class PasteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paste::class);
    }

    /**
     * @return Paste[] Returns an array of Paste objects
     */
    public function pagination(int $offset, int $limit = 10): array
    {
        $value = 'public';
        $q = $this->createQueryBuilder('p')
            ->andWhere('p.access = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        return collect($q->getQuery()->getResult())->map(fn($item) => ['title' => $item->getTitle()])->toArray();
    }

    /**
     * @return Paste[] Returns an array of Paste objects
     */
    public function paginationPrivate(int $offset, int $limit = 10, ?User $user): array
    {
        $value = 'private';
        $q = $this->createQueryBuilder('p')
            ->andWhere('p.access = :val')
            ->setParameter('val', $value)
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        return collect($q->getQuery()->getResult())->map(fn($item) => ['title' => $item->getTitle()])->toArray();
    }

    //    /**
    //     * @return Paste[] Returns an array of Paste objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Paste
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
