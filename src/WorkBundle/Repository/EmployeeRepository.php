<?php

namespace WorkBundle\Repository;

use Doctrine\ORM\EntityRepository;
use WorkBundle\Entity\Position;

class EmployeeRepository extends EntityRepository
{
    public function findAllByLike($param)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT e.id, e.fio, e.positionId, e.salary, e.date, p.name FROM WorkBundle:Employee e JOIN WorkBundle:Position p 
                          WHERE e.positionId = p.id AND
                          e.fio LIKE '%".$param."%' OR 
                          e.positionId LIKE '%".$param."%' OR
                          e.salary LIKE '%".$param."%'"
            )
            ->getResult();
    }

    public function getByArray()
    {
        return $this->getEntityManager()
            ->createQuery("SELECT e.id, e.fio, e.salary, e.positionId, e.date, p.name FROM WorkBundle:Employee e 
                JOIN WorkBundle:Position p 
                WHERE e.positionId = p.id 
                ORDER BY e.id ASC")
            ->getArrayResult();
    }
}
