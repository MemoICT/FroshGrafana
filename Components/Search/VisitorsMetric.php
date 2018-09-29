<?php

namespace FroshGrafana\Components\Search;

use FroshGrafana\Components\Dbal\SessionGateway;

class VisitorsMetric extends Metric implements MetricInterface
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
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return 'visitors';
    }

    /**
     * {@inheritdoc}
     */
    public function getStateSnapshotColumnName(): string
    {
        return 'visitors';
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Visitors';
    }

    /**
     * {@inheritdoc}
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