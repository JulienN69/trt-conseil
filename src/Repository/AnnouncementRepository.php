<?php

namespace App\Repository;

use App\Entity\Announcement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Announcement>
 *
 * @method Announcement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Announcement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Announcement[]    findAll()
 * @method Announcement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnouncementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Announcement::class);
    }

    public function paginateAnnouncement(int $page, int $limit): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('r'),
            $page,
            $limit
        );
    }

    public function findAllAnnoucementByRecruiterId(int $id, RecruiterRepository $recruiterRepo){

        $recruiter = $recruiterRepo->find($id);
    
        return $this->createQueryBuilder('a')
            ->where('a.recruiter = :recruiter')
            ->setParameter('recruiter', $recruiter)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Announcement[] Returns an array of Announcement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Announcement
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
