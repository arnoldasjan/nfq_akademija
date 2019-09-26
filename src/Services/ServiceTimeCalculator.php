<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class ServiceTimeCalculator {

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function calculateAvg()
    {
        $conn = $this->em->getConnection();

        $sql = 'select specialist_id, floor(avg(time_diff)) as service_avg
                from (
                select client_id, specialist_id, time_diff
                from (
                select client_id, visit.specialist_id, created_at, extract(epoch from(created_at-lag(created_at) over (partition by client_id order by client_id))) as time_diff
                from visit
                left join client c on visit.client_id = c.id
                where serviced is not null ) t
                where t.time_diff is not null) tt
                group by 1';

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function avgForOneClient(int $specialistId)
    {
        $conn = $this->em->getConnection();

        $sql = 'select floor(avg(time_diff)) as service_avg
                from (
                         select client_id, specialist_id, time_diff
                         from (
                                  select client_id, visit.specialist_id, created_at, extract(epoch from(created_at-lag(created_at) over (partition by client_id order by client_id))) as time_diff
                                  from visit
                                           left join client c on visit.client_id = c.id
                                  where serviced is not null and c.specialist_id=:specId ) t
                         where t.time_diff is not null) tt';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['specId' => $specialistId]);
        return $stmt->fetch();
    }
}