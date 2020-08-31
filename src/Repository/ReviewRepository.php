<?php

namespace App\Repository;

use App\Entity\Review;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    /**
     * get by hotel id and date range
     * @param int $hotelId              hotel id
     * @param DateTime $fromDate        from date object
     * @param DateTime $toDate          to date object
     * @param string $groupBy           group by (DAY, MONTH, YEAR)
     * @return array                    reviews array
     */
    public function getByHotelIdAndDateRange(
        int $hotelId,
        DateTime $fromDate,
        DateTime $toDate,
        string $groupBy
    ) {
        switch ($groupBy) {
            case 'DATE':
                $select = ', ' . $groupBy . '(r.createdDate) as datePeriod ';
                $groupByColumns = ['datePeriod'];
                break;
            case 'WEEK':
                $select = ', ' . $groupBy . '(r.createdDate, 3) as weekPeriod, ' .
                    'YEAR(r.createdDate) as yearPeriod';
                $groupByColumns = ['weekPeriod', 'yearPeriod'];
                break;
            case 'MONTH':
                $select = ', ' . $groupBy . '(r.createdDate) as monthPeriod, ' .
                    'YEAR(r.createdDate) as yearPeriod';
                $groupByColumns = ['monthPeriod', 'yearPeriod'];
                break;
            default:
                $select = '';
                $groupByColumns = null;
        }

        $query = $this->createQueryBuilder('r')
            ->select('count(r.id) as reviewCount, sum(r.score) as sumScore' . $select)
            ->andWhere('r.hotel = :hotelId')
            ->andWhere('r.createdDate >= :fromDate')
            ->andWhere('r.createdDate <= :toDate')
            ->setParameter('hotelId', $hotelId)
            ->setParameter('fromDate', $fromDate)
            ->setParameter('toDate', $toDate);

        if ($groupByColumns) {
            foreach ($groupByColumns as $col) {
                $query->addGroupBy($col);
                $query->addOrderBy($col);
            }
        }

        return $query->getQuery()->getResult();
    }
}
