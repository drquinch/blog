<?php

namespace MDMediaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ImageRepository extends EntityRepository
{
    public function findLimitedAll($batch, $page)
    {
        return $this->createQueryBuilder('x')
                     ->setFirstResult($page*$batch)
                     ->setMaxResults($batch)
                     ->getQuery()
                     ->getResult();
    }

    public function getCount()
    {
        return $this->createQueryBuilder('x')
                     ->select('COUNT(x)')
                     ->getQuery()
                     ->getSingleScalarResult();
    }
}
