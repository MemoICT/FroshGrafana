<?php

namespace FroshGrafana\Components\Search;

use FroshGrafana\Components\Dbal\CustomersGateway;

class CustomerRegistrationsMetric extends Metric implements MetricInterface
{
    /** @var CustomersGateway $customersGateway */
    private $customersGateway;

    /**
     * CustomerRegistrationsMetric constructor.
     *
     * @param CustomersGateway $customersGateway
     */
    public function __construct(CustomersGateway $customersGateway)
    {
        $this->customersGateway = $customersGateway;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return 'customers';
    }

    /**
     * {@inheritdoc}
     */
    public function getStateSnapshotColumnName(): string
    {
        return 'customer_registrations';
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Customers';
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

        return $this->customersGateway->getRegisterCount(
            $fromDate,
            $toDate,
            $this->getRequest()->getIntervalSeconds()
        );
    }
}