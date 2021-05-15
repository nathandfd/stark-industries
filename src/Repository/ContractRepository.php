<?php

namespace App\Repository;

use App\Entity\Contract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contract|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contract|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contract[]    findAll()
 * @method Contract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contract::class);
    }

    // /**
    //  * @return Contract[] Returns an array of Contract objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function hasUnpaidStatus($value)
    {
        $qb = $this->createQueryBuilder('c');
        return $qb
            ->where('c.status = 6')
            ->andWhere(
                $qb->expr()->orX(
                    'c.info_client LIKE :mobile',
                    $qb->expr()->orX(
                        'c.info_client LIKE :mail',
                        'c.info_prelevement LIKE :iban'
                    )
                )
            )
            ->setParameter('mobile', '%'.$value['mobile'].'%')
            ->setParameter('mail', '%'.$value['mail'].'%')
            ->setParameter('iban', '%'.$value['iban'].'%')
            ->getQuery()
            ->getResult()
        ;

    }

    public function isDuplicate($value)
    {
        $qb = $this->createQueryBuilder('c');
        return $qb
            ->andWhere(
                $qb->expr()->orX(
                    'c.info_client LIKE :mobile',
                    $qb->expr()->orX(
                        'c.info_client LIKE :mail',
                        'c.info_prelevement LIKE :iban'
                    )
                )
            )
            ->setParameter('mobile', '%'.$value['mobile'].'%')
            ->setParameter('mail', '%'.$value['mail'].'%')
            ->setParameter('iban', '%'.$value['iban'].'%')
            ->getQuery()
            ->getResult()
            ;

    }

    public function getNb($salesmanId) {

        return $this->createQueryBuilder('l')
            ->select('COUNT(l)')
            ->where('l.salesman = :salesmanId')
            ->setParameter('salesmanId', $salesmanId)
            ->getQuery()
            ->getSingleScalarResult();

    }
}
