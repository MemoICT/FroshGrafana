<?php

namespace FroshGrafana\Components\Search;

use FroshGrafana\Components\Dbal\SessionGateway;

class VisitorsMetric extends Metric
{
    /** @var SessionGateway $statisticsGateway */
    private $statisticsGateway;

    /**
     * VisitorsMetric constructor.
     *
     * @param SessionGateway $statisticsGateway
     */
    public function __construct(SessionGateway $statisticsGateway)
    {
        $this->statisticsGateway = $statisticsGateway;
    }

    /**
     * Returns the id of this metric which is used as target in query requests.
     *
     * @return string
     */
    public function getId(): string
    {
        return 'visitors';
    }

    /**
     * Returns the name of this metric which is shown in the 'find metric' options on the query tab in panels.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Visitors';
    }

    /**
     * @return array
     */
    public function getDataPoints(): array
    {
        $range = $this->getRequest()->getRange();
        $fromDate = new \DateTime($range['from']);
        $toDate = new \DateTime($range['to']);

        $fromDate->setTimezone(new \DateTimeZone(\date_default_timezone_get()));
        $toDate->setTimezone(new \DateTimeZone(\date_default_timezone_get()));

        return $this->statisticsGateway->getVisitorsCount(
            $fromDate,
            $toDate,
            $this->getRequest()->getIntervalSeconds()
        );
    }
}