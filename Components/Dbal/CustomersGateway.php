<?php

namespace FroshGrafana\Components\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class CustomersGateway
 */
class CustomersGateway
{
    /** @var Connection */
    private $connection;

    /**
     * CustomersGateway constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param \DateTime $fromDate
     * @param \DateTime $toDate
     * @param float $interval
     *
     * @return array
     */
    public function getRegisterCount(\DateTime $fromDate, \DateTime $toDate, float $interval): array
    {
        $query = $this->getCustomersRangeQuery($fromDate, $toDate, $interval);

        $result = $query->select('COUNT(id)', 'UNIX_TIMESTAMP(lastlogin) * 1000')->execute()->fetchAll();

        if (!$result) {
            return [];
        }

        foreach ($result as &$item) {
            $item = \array_values(\array_map('\intval', $item));
        }

        return $result;
    }

    /**
     * @param \DateTime $fromDate
     * @param \DateTime $toDate
     * @param float $interval
     * @return QueryBuilder
     */
    private function getCustomersRangeQuery(\DateTime $fromDate, \DateTime $toDate, float $interval): QueryBuilder
    {
        $query = $this->connection->createQueryBuilder();

        return $query->from('s_user')
            ->where(
                $query->expr()->andX(
                    $query->expr()->gte('lastlogin', ':fromDate'),
                    $query->expr()->lte('lastlogin', ':toDate'),
                    $query->expr()->eq('DATE_FORMAT(lastlogin, "%Y-%m-%d")', 'firstlogin')
                )
            )->groupBy('UNIX_TIMESTAMP(lastlogin) DIV :interval')
            ->setParameters(
                [
                    'fromDate' => $fromDate->format('Y-m-d H:i:s'),
                    'toDate'   => $toDate->format('Y-m-d H:i:s'),
                    'interval' => $interval,
                ]
            );
    }
}